<?php

namespace App\Http\Controllers;

use App\Models\AQI;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AQIController extends Controller
{
    public function store(Request $request)
{
     // Validate the incoming request data (optional but recommended)
     $request->validate([
        'city' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'aqi_level' => 'required|integer',
    ]);

    // Get data from the request
    $city = $request->input('city');
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $aqi_level = $request->input('aqi_level');

    // Save the data to the database
    AQI::create([
        'city' => $city,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'aqi_level' => $aqi_level,
    ]);

    // Return a response
    return response()->json([
        'message' => 'Data saved successfully',
        'city' => $city,
        'aqi_level' => $aqi_level,
    ]);
}

}
