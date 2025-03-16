<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center text-gray-800">Welcome to Admin Dashboard</h1>
        <p class="text-center text-gray-600 mt-2">Manage users, approvals, and more.</p>

        <div class="mt-6 flex justify-center">
            <a href="{{ route('admin.users') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg">View Users</a>
            <a href="{{ route('admin.logout') }}" class="bg-red-500 text-white px-6 py-2 ml-4 rounded-lg hover:bg-red-600 transition duration-300">
                Logout
            </a>
        </div>
    </div>
</body>
</html>
