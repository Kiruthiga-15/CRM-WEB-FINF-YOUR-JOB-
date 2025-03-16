{{-- //register.blade.php  --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4F46E5', // Indigo
                        secondary: '#9333EA', // Purple
                        success: '#10B981', // Green
                        danger: '#EF4444', // Red
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-r from-primary to-secondary text-white font-sans">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md text-gray-900 transition-all duration-300 hover:shadow-2xl">
        
        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-success text-white text-center py-2 px-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-danger text-white text-center py-2 px-4 rounded mb-4">
                <ul class="list-none">
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Registration Form -->
        <h2 class="text-3xl font-bold text-center text-primary mb-6">User Registration</h2>

        <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <!-- Name -->
            <div>
                <label class="block font-semibold">Full Name</label>
                <input type="text" name="name" required 
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300 hover:border-secondary hover:shadow-md"
                    placeholder="Enter your full name">
            </div>

            <!-- Email -->
            <div>
                <label class="block font-semibold">Email Address</label>
                <input type="email" name="email" required 
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300 hover:border-secondary hover:shadow-md"
                    placeholder="Enter your email">
            </div>

            <!-- Phone -->
            <div>
                <label class="block font-semibold">Phone Number</label>
                <input type="tel" name="phone" required 
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300 hover:border-secondary hover:shadow-md"
                    placeholder="Enter your phone number">
            </div>

            <!-- ID Proof Upload -->
            <div>
                <label class="block font-semibold">Upload ID Proof</label>
                <input type="file" name="id_proof" accept=".jpg, .png, .pdf" required 
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary file:bg-primary file:text-white file:px-4 file:py-2 file:border-none file:rounded-lg file:cursor-pointer transition-all duration-300 hover:border-secondary hover:shadow-md">
                <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, PNG, PDF</p>
            </div>

            <!-- Address Proof Upload -->
            <div>
                <label class="block font-semibold">Upload Address Proof</label>
                <input type="file" name="address_proof" accept=".jpg, .png, .pdf" required 
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary file:bg-primary file:text-white file:px-4 file:py-2 file:border-none file:rounded-lg file:cursor-pointer transition-all duration-300 hover:border-secondary hover:shadow-md">
                <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, PNG, PDF</p>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                class="w-full bg-primary text-white py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition-all duration-300">
                Register
            </button>
        </form>
    </div>

</body>
</html>
