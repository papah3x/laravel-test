<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    // Add this:
    protected $fillable = [
        'name',
        'description',
        'price_per_night',
        'image', // add this if you have an image field in your DB
    ];

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
