<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sensor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SensorController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
       $incomingField = $request->validate([
            'location' => 'required|string|max:255',
            'long' => 'required',
            'lat' => 'required',
           
        ]);

        Sensor::create($incomingField);

        // Process the registration logic here (e.g., save to database)
        // For demonstration, we'll just return the incoming data as a JSON response

    return response()->json([
            'message' => 'Sensor registered successfully',
            'sensor' => $incomingField,
        ]);
        
    }
    
}
