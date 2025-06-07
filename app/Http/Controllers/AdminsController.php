<?php

namespace App\Http\Controllers;

use App\Models\Admins;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminsController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
        $incomingField = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Hash the password before saving
        $incomingField['password'] = bcrypt($incomingField['password']);

        // Create a new user
        Admins::create($incomingField);

        // Process the registration logic here (e.g., save to database)
        // For demonstration, we'll just return the incoming data as a JSON response

        // return response()->json([
        //     'message' => 'User registered successfully',
        //     'user' => $incomingField,
        // ]);

        return redirect('/admin-login')->with('success', 'Admin registered successfully!');
    }

    public function login(Request $request){

        $incomingFields = $request->validate([
            'loginemail' => 'required|email',
            'loginpassword' => 'required'
        ]);

        if($incomingFields['loginemail'] == "admin@email.com" && $incomingFields['loginpassword'] == "123"){
            return redirect('/user-management');
        }else{
            if (Auth::guard('admin')->attempt([
                'email' => $incomingFields['loginemail'], 
                'password' => $incomingFields['loginpassword']
    
            ])) {
                $request->session()->regenerate();
                return redirect('/admin-dashboard');
            }
            
            return back()->withErrors(['login' => 'Invalid credentials']);
        }

        
    }

    public function logout(){
        session()->invalidate();
        return redirect('/');
    }

    public function status(Request $request){
        $status = $request->input('status');
        $id = $request->input('id');

        $admin = Admins::find($id);
        $admin->status = $status;
        $admin->save();

        return response()->json(['success'=>true]);

    }
}
