<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserLoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('user.userlogin');
    }

    // Handle login logic
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard')->with('success', 'Login Successful!');
        } else {
            return back()->with('error', 'Invalid Credentials!');
        }
    }

    // Logout user
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('userlogin')->with('success', 'Logged out successfully!');
    }
}
