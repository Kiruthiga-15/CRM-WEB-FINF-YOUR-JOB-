<?php
namespace App\Http\Controllers\Auth; // Ensure "Auth" is capitalized

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller; // Add this if missing
use App\Models\Admin;
use App\Models\User;

class AdminController extends Controller
{
    // Show Admin Login Page
    public function showLoginForm()
    {
        return view('admin.login'); // Ensure file exists: resources/views/admin/login.blade.php
    }

    // Handle Admin Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.users'); // Redirect to users page
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Show User Management Page
    public function users()
    {
        $users = User::all(); // Fetch users from the database
        return view('admin.user', compact('users')); // Ensure file exists: resources/views/admin/user.blade.php
    }

    // Update User Status via AJAX
    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => true, 'status' => $user->status]);
    }

    // Admin Logout
public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // Change 'web' if using a different guard

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login'); // Redirect to Admin Login
    }


}