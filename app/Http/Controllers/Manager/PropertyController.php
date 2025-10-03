<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $properties = Property::query()
            ->withCount(['bookings as booked_today_count' => function ($q) use ($today) {
                $q->whereIn('status', ['pending', 'confirmed'])
                  ->where('start_date', '<=', $today)
                  ->where('end_date', '>', $today);
            }])
            ->get();
        return view('manager.dashboard', compact('properties'));
    }

    public function create()
    {
        return view('manager.create-property');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price_per_night' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Store on the default filesystem disk for environment-agnostic behavior
            $data['image'] = $request->file('image')->store('properties');
        }

        Property::create($data);

        return redirect()->route('manager.dashboard')->with('success', 'Property added!');
    }
    public function edit(Property $property)
    {
        if (request()->ajax()) {
            return view('manager.partials.property-form', compact('property'))->render();
        }
        
        return view('manager.edit-property', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price_per_night' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($property->image) {
                \Storage::delete($property->image);
            }
            $data['image'] = $request->file('image')->store('properties');
        }

        $property->update($data);

        if ($request->ajax()) {
            return response()->json([
                'redirect' => route('manager.dashboard')
            ]);
        }

        return redirect()->route('manager.dashboard')
            ->with('success', 'Property updated!');
    }

    public function destroy(Property $property)
    {
        if ($property->image) {
            \Storage::delete($property->image);
        }
        $property->delete();
        return back()->with('success', 'Property deleted!');
    }
}
