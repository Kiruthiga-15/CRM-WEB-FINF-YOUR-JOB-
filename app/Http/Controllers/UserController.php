<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
//popup
    public function updateProofStatus(Request $request) {
    $user = User::find($request->user_id);
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }
 // Update proof status
    if ($request->proof_type == 'id_proof') {
        $user->id_proof_status = $request->status;
    } elseif ($request->proof_type == 'address_proof') {
        $user->address_proof_status = $request->status;
    }
    
    // Check if both proofs are approved, then update user status
    if ($user->id_proof_status === 'approved' && $user->address_proof_status === 'approved') {
        $user->status = 'approved';
    } else {
        $user->status = 'pending'; // Default status if any proof is not approved
    }

    $user->save();
    return response()->json(['message' => 'Proof status updated successfully']);
}

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
            'password' => Hash::make($request->password),
            'id_proof' => $idProofPath,
            'address_proof' => $addressProofPath,
            'proof_status' => 'Waiting for Approval',
        ]);

        return redirect()->route('admin.users')->with('success', 'User registered successfully!');
    }

//reupload
public function reuploadProof(Request $request)
{
    $request->validate([
        'id_proof_reupload' => 'nullable|mimes:jpg,png,pdf|max:2048',
        'address_proof_reupload' => 'nullable|mimes:jpg,png,pdf|max:2048',
    ]);

    $user = User::find($request->user_id);

    if ($request->hasFile('id_proof_reupload')) {
        $idProofPath = $request->file('id_proof_reupload')->store('proofs', 'public');
        $user->id_proof = $idProofPath;
        $user->id_proof_status = 'pending'; // Reset status
    }

    if ($request->hasFile('address_proof_reupload')) {
        $addressProofPath = $request->file('address_proof_reupload')->store('proofs', 'public');
        $user->address_proof = $addressProofPath;
        $user->address_proof_status = 'pending'; // Reset status
    }

    $user->save();

    return redirect()->back()->with('success', 'Proofs reuploaded successfully and are under review.');
}
//new
 public function index()
    {
        // Fetch users from the User model
        $users = User::latest()->get();
        return view('admin.user', compact('users'));
    }


}
