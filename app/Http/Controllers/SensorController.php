<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sensor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        $incomingField['admins_id'] = Auth::guard('admin')->id();

        Sensor::create($incomingField);

        return redirect('/admin-dashboard')->with('success', 'Sensor registered successfully!');
        
    }

    public function status(Request $request){
        $status = $request->input('status');
        $id = $request->input('id');

        $sensor = Sensor::find($id);
        $sensor->status = $status;
        $sensor->save();

        return response()->json(['success'=>true]);

    }

    public function loadChart(Request $request){

    }
    
}
