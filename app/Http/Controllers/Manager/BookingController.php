<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'property']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->where('start_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->where('end_date', '<=', $request->end_date);
        }

        // Order pending first, then by newest
        $bookings = $query
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $pendingCount = Booking::pending()->count();

        return view('manager.bookings.index', compact('bookings', 'pendingCount'));
    }

    public function create()
    {
        $properties = Property::all();
        $clients = User::where('role', 'client')->get();
        
        return view('manager.bookings.create', compact('properties', 'clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,confirmed,cancelled',
            'total_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Prevent overlapping bookings for the same property (treat pending and confirmed as blocking)
        $overlapExists = Booking::where('property_id', $data['property_id'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($data) {
                // Overlap if existing.start < new.end AND existing.end > new.start
                $q->where('start_date', '<', $data['end_date'])
                  ->where('end_date', '>', $data['start_date']);
            })
            ->exists();

        if ($overlapExists && $data['status'] !== 'cancelled') {
            return back()
                ->withErrors(['date' => 'This property is already booked for the selected dates.'])
                ->withInput();
        }

        Booking::create($data);

        return redirect()->route('manager.bookings.index')
            ->with('success', 'Booking created successfully!');
    }

    public function edit(Booking $booking)
    {
        $properties = Property::all();
        $clients = User::where('role', 'client')->get();
        
        return view('manager.bookings.edit', compact('booking', 'properties', 'clients'));
    }

    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,confirmed,cancelled',
            'total_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Prevent overlapping bookings for the same property (exclude current booking)
        $overlapExists = Booking::where('property_id', $data['property_id'])
            ->where('id', '!=', $booking->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($data) {
                $q->where('start_date', '<', $data['end_date'])
                  ->where('end_date', '>', $data['start_date']);
            })
            ->exists();

        if ($overlapExists && $data['status'] !== 'cancelled') {
            return back()
                ->withErrors(['date' => 'This property is already booked for the selected dates.'])
                ->withInput();
        }

        $booking->update($data);

        return redirect()->route('manager.bookings.index')
            ->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        
        return back()->with('success', 'Booking deleted successfully!');
    }

    public function confirm(Booking $booking)
    {
        // Ensure confirming does not overlap with other confirmed/pending bookings
        $overlapExists = Booking::where('property_id', $booking->property_id)
            ->where('id', '!=', $booking->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($booking) {
                $q->where('start_date', '<', $booking->end_date)
                  ->where('end_date', '>', $booking->start_date);
            })
            ->exists();

        if ($overlapExists) {
            return back()->withErrors(['date' => 'Cannot confirm: this property is already booked for the selected dates.']);
        }

        $booking->update(['status' => 'confirmed']);
        
        return back()->with('success', 'Booking confirmed successfully!');
    }

    public function cancel(Request $request, Booking $booking)
    {
        $notes = $request->input('notes');
        $booking->update([
            'status' => 'cancelled',
            'notes' => $notes,
        ]);
        
        return back()->with('success', 'Booking cancelled successfully!');
    }

    public function pending()
    {
        $bookings = Booking::with(['user', 'property'])
            ->pending()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('manager.bookings.pending', compact('bookings'));
    }
}
