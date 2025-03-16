<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10',
            'document' => 'required|file|mimes:jpg,png,pdf|max:2048', // Secure file upload
        ]);

        // Store file securely
        $path = $request->file('document')->store('uploads', 'public');

        // Store user data (You need a User model and migration)
        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'document_path' => $path,
        ]);

        return redirect('/')->with('success', 'Registration Successful!');
    }
    // Show the registration form
    public function create()
    {
        return view('user.register');
    }

    // Handle the registration form submission
 public function store(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:15',
        'id_proof' => 'required|mimes:jpg,png,pdf|max:2048',
        'address_proof' => 'required|mimes:jpg,png,pdf|max:2048',
    ]);

    // Handle file uploads
    $idProofPath = $request->file('id_proof')->store('proofs', 'public');
    $addressProofPath = $request->file('address_proof')->store('proofs', 'public');

    // Create a new user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'id_proof' => $idProofPath,
        'address_proof' => $addressProofPath,
        'status' => 'pending', // default status, can be modified later
        'password' => Hash::make('defaultpassword'), // Optional: Hash password if needed
    ]);

    // Redirect back with success message
    return redirect()->route('user.register')->with('success', 'Registration successful!');
}



}
