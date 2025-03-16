{{-- //user.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gradient-to-r from-blue-50 to-purple-100 p-6">
    <div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">User Management</h2>

        <!-- Filters -->
        <div class="mb-4 flex gap-3">
            <input type="text" id="emailSearch" placeholder="Search by Email" class="p-2 border rounded shadow-md">
            <select id="statusFilter" class="p-2 border rounded shadow-md">
                <option value="">All Statuses</option>
                <option value="approved">Approved</option>
                <option value="pending">Pending</option>
                <option value="rejected">Rejected</option>
            </select>
            <button onclick="filterUsers()" class="bg-blue-500 text-white px-4 py-2 rounded shadow-md hover:bg-blue-600 transition">Search</button>
        </div>

        <!-- Users Table -->
        <table class="w-full border-collapse border rounded-lg shadow-md">
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
                    
                    <!-- ID Proof Column -->
                    <td class="border p-2 text-center">
                        @if($user->id_proof)
                            <a href="{{ asset('storage/' . $user->id_proof) }}" target="_blank" class="text-blue-500 underline hover:text-blue-700">View</a>
                        @else
                            <span class="text-red-500">Not Uploaded</span>
                        @endif
                    </td>

                    <!-- Address Proof Column -->
                    <td class="border p-2 text-center">
                        @if($user->address_proof)
                            <a href="{{ asset('storage/' . $user->address_proof) }}" target="_blank" class="text-blue-500 underline hover:text-blue-700">View</a>
                        @else
                            <span class="text-red-500">Not Uploaded</span>
                        @endif
                    </td>

                    <!-- Status Column with Colors -->
                    <td class="border p-2 font-semibold">
                        <span class="status px-2 py-1 rounded-lg text-white
                            @if($user->status == 'approved') bg-green-500 @elseif($user->status == 'pending') bg-yellow-500 @else bg-red-500 @endif">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>

                    <td class="border p-2 text-center">
                        <button class="bg-green-500 text-white px-3 py-1 rounded shadow-md hover:bg-green-600 transition approve-btn" data-id="{{ $user->id }}">Approve</button>
                        <button class="bg-red-500 text-white px-3 py-1 rounded shadow-md hover:bg-red-600 transition reject-btn" data-id="{{ $user->id }}">Reject</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

  <script>
    function filterUsers() {
        let email = document.getElementById("emailSearch").value.toLowerCase();
        let status = document.getElementById("statusFilter").value.toLowerCase();
        let rows = document.querySelectorAll("#userTable tr");

        rows.forEach(row => {
            let emailText = row.cells[2].innerText.toLowerCase();
            let statusText = row.cells[5].innerText.toLowerCase();

            if ((email === "" || emailText.includes(email)) &&
                (status === "" || statusText === status)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".approve-btn").forEach(button => {
            button.addEventListener("click", function() {
                let userId = this.dataset.id;
                updateStatus(userId, "approved", this);
            });
        });

        document.querySelectorAll(".reject-btn").forEach(button => {
            button.addEventListener("click", function() {
                let userId = this.dataset.id;
                updateStatus(userId, "rejected");
            });
        });
    });

    function updateStatus(userId, status, approveBtn = null) {
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

                // Find the row associated with this user
                let row = document.querySelector(`button[data-id='${userId}']`).closest("tr");
                
                // Update the status text and background color
                let statusCell = row.querySelector(".status");
                statusCell.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                statusCell.className = `status px-2 py-1 rounded-lg text-white ${status === 'approved' ? 'bg-green-500' : 'bg-red-500'}`;

                // If approved, remove the reject button
                if (status === "approved") {
                    let rejectBtn = row.querySelector(".reject-btn");
                    if (rejectBtn) {
                        rejectBtn.remove();
                    }
                }
            }
        })
        .catch(error => console.error("Error:", error));
    }
</script>

</body>
</html>
