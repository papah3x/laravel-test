<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingManager extends Component
{
    public $propertyId;
    public $startDate;
    public $endDate;
    public $successMessage = '';

    public function createBooking()
    {
        $this->validate([
            'propertyId' => 'required|exists:properties,id',
            'startDate' => 'required|date|after_or_equal:today',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'property_id' => $this->propertyId,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);

        $this->reset(['startDate', 'endDate']);
        $this->successMessage = 'Réservation enregistrée !';

        // Dispatch event for Alpine.js notification
        $this->dispatch('bookingCreated');
    }

    public function render()
    {
        return view('livewire.booking-manager', [
            'properties' => Property::all(),
            'bookings' => Booking::with('property')->where('user_id', Auth::id())->latest()->get(),
        ]);
    }
}
