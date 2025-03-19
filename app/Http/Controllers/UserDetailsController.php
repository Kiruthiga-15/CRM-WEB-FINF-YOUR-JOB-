<?php
namespace App\Http\Controllers;
use App\Models\User;


use App\Models\UserDetails; // ✅ Add this line
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class UserDetailsController extends Controller
{ 



 public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:20',
        'password' => 'required|string|min:6',
        'id_proof' => 'required|mimes:jpg,png,pdf|max:2048',
        'address_proof' => 'required|mimes:jpg,png,pdf|max:2048',
    ]);

    $idProofPath = $request->file('id_proof')->store('proofs', 'public');
    $addressProofPath = $request->file('address_proof')->store('proofs', 'public');

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password), // Hashing the password
        'id_proof' => $idProofPath,
        'address_proof' => $addressProofPath,
        'proof_status' => 'Waiting for Approval',
    ]);

    return redirect()->route('user.login')->with('success', 'User registered successfully!');
}

    public function index()
    {
        // Fetch all users
        $users = UserDetails::all();
        return view('admin.user', compact('users'));
    }


}
