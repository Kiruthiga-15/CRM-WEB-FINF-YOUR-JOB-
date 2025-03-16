<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:email',
            'id_proof' => 'required|file|mimes:jpg,png,pdf|max:2048', // Adjust file types and size
            'address_proof' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        // Upload ID Proof
        $idProofPath = $request->file('id_proof')->store('proofs', 'public');
        $addressProofPath = $request->file('address_proof')->store('proofs', 'public');

        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'id_proof' => $idProofPath,
            'address_proof' => $addressProofPath,
            'status' => 'pending',
        ]);

        Auth::login($user); // Auto-login the user after registration
return redirect()->route('admin.dashboard')->with('success', 'Registration successful!'); // Redirect to dashboard
    }
     public function store(Request $request)
    {
        // Validate input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:email',
            'phone' => 'required|digits:10|numeric', // Ensures exactly 10 digits
            'id_proof' => 'required|mimes:jpg,png,pdf|max:2048',
            'address_proof' => 'required|mimes:jpg,png,pdf|max:2048',
            'password' => 'required|min:6|confirmed',
        ]);

        // Store files
        $idProofPath = $request->file('id_proof')->store('proofs', 'public');
        $addressProofPath = $request->file('address_proof')->store('proofs', 'public');

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'id_proof' => $idProofPath,
            'address_proof' => $addressProofPath,
            'password' => bcrypt($request->password),
            'status' => 'pending', // Default status
            'role' => 'user', // Default role
        ]);

        // Auto-login user after registration
        Auth::login($user);

        // Redirect to the admin dashboard
 return redirect()->route('admin.dashboard')->with('success', 'Registration successful!');

    }
}

