<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5', // Indigo
                        dark: '#1F2937', // Dark Gray
                        light: '#F3F4F6', // Light Gray
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-200 to-gray-400 flex items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8">

    <div class="w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-md bg-white p-8 sm:p-10 rounded-2xl shadow-2xl transition-transform transform hover:scale-105 duration-300">
        <h2 class="text-3xl font-extrabold text-dark text-center mb-6">Admin Login</h2>

        <!-- Error Message -->
        <div id="error-message" class="hidden bg-red-500 text-white p-3 rounded-lg mb-4 text-center shadow-md"></div>

        <form id="login-form" action="{{ route('admin.login') }}" method="POST">
            @csrf

            <!-- Email Input -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary transition duration-200 hover:border-primary">
            </div>

            <!-- Password Input with Toggle -->
            <div class="mb-6 relative">
                <label class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" id="password" name="password" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary transition duration-200 hover:border-primary">
                <button type="button" id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-800 transition">
                    🔍
                </button>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                class="w-full bg-primary text-white py-3 rounded-lg text-lg font-semibold hover:bg-indigo-700 transition duration-300 shadow-md">
                Login
            </button>

            <!-- Forgot Password -->
            <div class="text-center mt-4">
                <a href="/forgot-password" class="text-primary font-medium hover:underline transition duration-200">Forgot Password?</a>
            </div>
        </form>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordBtn = document.getElementById('togglePassword');

        togglePasswordBtn.addEventListener('mousedown', function () {
            passwordInput.type = 'text';
        });

        togglePasswordBtn.addEventListener('mouseup', function () {
            passwordInput.type = 'password';
        });

        togglePasswordBtn.addEventListener('mouseleave', function () {
            passwordInput.type = 'password';
        });
    </script>

</body>
</html>
