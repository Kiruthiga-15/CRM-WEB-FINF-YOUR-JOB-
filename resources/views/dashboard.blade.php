<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-2xl mx-4">
        <!-- Welcome Message -->
        <h2 class="text-2xl font-bold text-center mb-4">Welcome, {{ Auth::user()->name }}</h2>

        <!-- Proof Status -->
        <p class="text-center text-gray-700 mb-4">
            Your proof status: 
            <span class="font-semibold text-blue-600">{{ Auth::user()->id_proof_status }}</span>, 
            <span class="font-semibold text-blue-600">{{ Auth::user()->address_proof_status }}</span>
        </p>

        <!-- Reupload Proofs -->
        <div class="bg-gray-50 p-4 rounded-lg shadow-md mb-4">
            <h3 class="text-lg font-semibold mb-2">Reupload Proofs</h3>
            <form action="{{ route('users.reupload-proof') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="block font-medium">ID Proof</label>
                    <input type="file" name="id_proof" required class="block w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-3">
                    <label class="block font-medium">Address Proof</label>
                    <input type="file" name="address_proof" required class="block w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                    Reupload
                </button>
            </form>
        </div>

        <!-- Logout Button -->
      <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700">
        Logout
    </button>
</form>
    </div>

</body>
</html>
