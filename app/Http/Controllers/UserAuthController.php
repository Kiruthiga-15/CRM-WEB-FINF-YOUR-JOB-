<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserAuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('user.userlogin');
    }

    // Handle user login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard')->with('success', 'Logged in successfully.');
        }

        return back()->with('error', 'Invalid email or password.');
    }

    // Logout user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.login')->with('success', 'Logged out successfully.');
    }
}
