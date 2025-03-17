<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gradient-to-r from-blue-50 to-purple-100 p-4 md:p-6">
    <div class="container mx-auto p-4 bg-white shadow-lg rounded-lg w-full max-w-6xl">
        <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6 text-gray-800 text-center">User Management</h2>

        <!-- Filters -->
        <div class="mb-4 flex flex-col md:flex-row gap-3">
            <input type="text" id="emailSearch" placeholder="Search by Email" class="p-2 border rounded shadow-md w-full md:w-1/3">
            <select id="statusFilter" class="p-2 border rounded shadow-md w-full md:w-1/4">
                <option value="">All Statuses</option>
                <option value="approved">Approved</option>
                <option value="pending">Pending</option>
                <option value="rejected">Rejected</option>
            </select>
            <button onclick="filterUsers()" class="bg-blue-500 text-white px-4 py-2 rounded shadow-md hover:bg-blue-600 transition w-full md:w-auto">Search</button>
            <a href="#" onclick="document.getElementById('logout-form').submit();"
                class="bg-red-500 text-white px-4 py-2 rounded shadow-md hover:bg-red-600 transition w-full md:w-auto text-center">
                Logout
            </a>
        </div>

        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border rounded-lg shadow-md text-sm md:text-base">
                <thead>
                    <tr class="bg-blue-200 text-gray-800">
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Email</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    @foreach($users as $user)
                    <tr class="border hover:bg-gray-100 transition">
                        <td class="border p-2">{{ $loop->iteration }}</td>
                        <td class="border p-2">{{ $user->name }}</td>
                        <td class="border p-2">{{ $user->email }}</td>
                        <td class="border p-2 font-semibold text-center">
                            <span class="status px-2 py-1 rounded-lg text-white text-xs md:text-sm
                                @if($user->status == 'approved') bg-green-500 @elseif($user->status == 'pending') bg-yellow-500 @else bg-red-500 @endif">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="border p-2 text-center">
                            <button class="bg-blue-500 text-white px-3 py-1 rounded shadow-md hover:bg-blue-600 transition text-xs md:text-sm view-proof-btn" 
                                data-id="{{ $user->id }}"
                                data-id-proof="{{ $user->id_proof ? asset('storage/' . $user->id_proof) : '' }}"
                                data-address-proof="{{ $user->address_proof ? asset('storage/' . $user->address_proof) : '' }}">
                                View Proof
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Popup -->
    <div id="proofModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full relative">
            <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>

            <h3 class="text-xl font-bold mb-4">User Proof Details</h3>

            <div id="proofContent">
                <!-- ID Proof -->
                <p class="font-semibold text-gray-700">ID Proof:</p>
                <img id="idProofImg" src="" class="w-32 h-32 object-cover mx-auto my-2 hidden">
                <p id="noIdProof" class="text-red-500 text-sm hidden">Not Uploaded</p>

                <!-- Address Proof -->
                <p class="font-semibold text-gray-700 mt-4">Address Proof:</p>
                <img id="addressProofImg" src="" class="w-32 h-32 object-cover mx-auto my-2 hidden">
                <p id="noAddressProof" class="text-red-500 text-sm hidden">Not Uploaded</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const proofModal = document.getElementById("proofModal");
            const closeModal = document.getElementById("closeModal");

            document.querySelectorAll(".view-proof-btn").forEach(button => {
                button.addEventListener("click", function() {
                    let idProof = this.dataset.idProof;
                    let addressProof = this.dataset.addressProof;

                    // Set ID Proof
                    if (idProof) {
                        document.getElementById("idProofImg").src = idProof;
                        document.getElementById("idProofImg").classList.remove("hidden");
                        document.getElementById("noIdProof").classList.add("hidden");
                    } else {
                        document.getElementById("idProofImg").classList.add("hidden");
                        document.getElementById("noIdProof").classList.remove("hidden");
                    }

                    // Set Address Proof
                    if (addressProof) {
                        document.getElementById("addressProofImg").src = addressProof;
                        document.getElementById("addressProofImg").classList.remove("hidden");
                        document.getElementById("noAddressProof").classList.add("hidden");
                    } else {
                        document.getElementById("addressProofImg").classList.add("hidden");
                        document.getElementById("noAddressProof").classList.remove("hidden");
                    }

                    // Show Modal
                    proofModal.classList.remove("hidden");
                });
            });

            // Close Modal
            closeModal.addEventListener("click", function() {
                proofModal.classList.add("hidden");
            });

            proofModal.addEventListener("click", function(event) {
                if (event.target === proofModal) {
                    proofModal.classList.add("hidden");
                }
            });
        });
    </script>
</body>
</html>
