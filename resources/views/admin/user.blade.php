<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <th class="border p-2">ID Proof</th>
                        <th class="border p-2">Address Proof</th>
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
                        <td class="border p-2 text-center">
                            @if($user->id_proof)
                                <a href="{{ asset('storage/' . $user->id_proof) }}" target="_blank" class="text-blue-500 underline hover:text-blue-700">View</a>
                            @else
                                <span class="text-red-500">Not Uploaded</span>
                            @endif
                        </td>
                        <td class="border p-2 text-center">
                            @if($user->address_proof)
                                <a href="{{ asset('storage/' . $user->address_proof) }}" target="_blank" class="text-blue-500 underline hover:text-blue-700">View</a>
                            @else
                                <span class="text-red-500">Not Uploaded</span>
                            @endif
                        </td>
                        <td class="border p-2 font-semibold text-center">
                            <span class="status px-2 py-1 rounded-lg text-white text-xs md:text-sm
                                @if($user->status == 'approved') bg-green-500 @elseif($user->status == 'pending') bg-yellow-500 @else bg-red-500 @endif">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="border p-2 text-center flex flex-col md:flex-row gap-2 justify-center">
                            <button class="bg-green-500 text-white px-3 py-1 rounded shadow-md hover:bg-green-600 transition text-xs md:text-sm approve-btn" data-id="{{ $user->id }}">Approve</button>
                            <button class="bg-red-500 text-white px-3 py-1 rounded shadow-md hover:bg-red-600 transition text-xs md:text-sm reject-btn" data-id="{{ $user->id }}">Reject</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterUsers() {
            let email = document.getElementById("emailSearch").value.toLowerCase();
            let status = document.getElementById("statusFilter").value.toLowerCase();
            let rows = document.querySelectorAll("#userTable tr");
            rows.forEach(row => {
                let emailText = row.cells[2].innerText.toLowerCase();
                let statusText = row.cells[5].innerText.toLowerCase();
                row.style.display = (email === "" || emailText.includes(email)) && (status === "" || statusText === status) ? "" : "none";
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".approve-btn").forEach(button => {
                button.addEventListener("click", function() {
                    let userId = this.dataset.id;
                    updateStatus(userId, "approved");
                });
            });

            document.querySelectorAll(".reject-btn").forEach(button => {
                button.addEventListener("click", function() {
                    let userId = this.dataset.id;
                    updateStatus(userId, "rejected");
                });
            });
        });

        function updateStatus(userId, status) {
            fetch(`/admin/users/${userId}/update-status`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ status: status }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`User status updated to ${status}`);
                    let row = document.querySelector(`button[data-id='${userId}']`).closest("tr");
                    let statusCell = row.querySelector(".status");
                    statusCell.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    statusCell.className = `status px-2 py-1 rounded-lg text-white ${status === 'approved' ? 'bg-green-500' : 'bg-red-500'}`;
                }
            })
            .catch(error => console.error("Error:", error));
        }
    </script>
</body>
</html>