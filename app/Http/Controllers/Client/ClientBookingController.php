<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ClientBookingController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
            'notes'      => 'nullable|string',
        ]);

        // Prevent overlapping bookings for the same property (pending and confirmed block)
        $overlapExists = Booking::where('property_id', $data['property_id'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($data) {
                $q->where('start_date', '<', $data['end_date'])
                  ->where('end_date', '>', $data['start_date']);
            })
            ->exists();

        if ($overlapExists) {
            return back()
                ->withErrors(['date' => 'This property is already booked for the selected dates.'])
                ->withInput();
        }

        $property = Property::findOrFail($data['property_id']);
        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);
        $nights = $start->diffInDays($end);

        if ($nights < 1) {
            return back()->withErrors(['date' => 'Stay must be at least 1 night.'])->withInput();
        }

        $totalPrice = (float) $property->price_per_night * $nights;

        Booking::create([
            'user_id'     => $user->id,
            'property_id' => $data['property_id'],
            'start_date'  => $data['start_date'],
            'end_date'    => $data['end_date'],
            'status'      => 'pending',
            'total_price' => $totalPrice,
            'notes'       => $data['notes'] ?? null,
        ]);

        return redirect()->route('client.dashboard')
            ->with('success', 'Your booking request has been submitted and is pending approval.');
    }
}
