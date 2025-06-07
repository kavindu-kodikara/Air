<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
        $incomingField = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Hash the password before saving
        $incomingField['password'] = bcrypt($incomingField['password']);

        // Create a new user
        User::create($incomingField);

        // Process the registration logic here (e.g., save to database)
        // For demonstration, we'll just return the incoming data as a JSON response

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $incomingField,
        ]);
    }
}

?>