<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Featured/available properties (basic example: latest 9)
        $properties = Property::orderBy('created_at', 'desc')->take(9)->get();

        // Client's bookings with relations
        $bookings = Booking::with(['property'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('client.dashboard', compact('properties', 'bookings'));
    }
}
