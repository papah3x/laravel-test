<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function show(Request $request, Property $property)
    {
        return view('client.properties.show', compact('property'));
    }
}
