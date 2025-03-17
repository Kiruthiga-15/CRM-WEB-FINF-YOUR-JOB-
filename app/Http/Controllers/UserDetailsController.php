<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDetails;

class UserDetailsController extends Controller
{
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_details,email',
            'phone' => 'required|string|max:20',
            'id_proof' => 'required|mimes:jpg,png,pdf|max:2048',
            'address_proof' => 'required|mimes:jpg,png,pdf|max:2048',
        ]);

        // Handle file uploads
        $idProofPath = $request->file('id_proof')->store('proofs', 'public');
        $addressProofPath = $request->file('address_proof')->store('proofs', 'public');

        // Store user data
        UserDetails::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'id_proof' => $idProofPath,
            'address_proof' => $addressProofPath,
        ]);

        return redirect()->back()->with('success', 'Registration successful!');
    }

}
