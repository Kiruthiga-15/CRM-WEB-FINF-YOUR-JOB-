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
   <button class="bg-yellow-500 text-white px-3 py-1 rounded shadow-md hover:bg-yellow-600 transition text-xs md:text-sm edit-btn" 
        data-id="{{ $user->id }}" 
        data-name="{{ $user->name }}" 
        data-email="{{ $user->email }}" 
        data-idproof="{{ asset('storage/' . $user->id_proof) }}" 
        data-addressproof="{{ asset('storage/' . $user->address_proof) }}"
        data-status="{{ $user->status }}">
        Edit
    </button>
</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
{{-- pagination
        <div class="mt-4">
    {{ $users->links() }}  <!-- Generates pagination buttons -->
</div> --}}


    </div>
<!-- Proof View Modal -->
<div id="proofModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-bold mb-2">User Proof</h2>
        <p class="text-gray-600 mb-2" id="modalUserName"></p>

        <!-- Proof Display -->
        <div class="mb-4">
            <h3 class="text-sm font-semibold">ID Proof:</h3>
            <a id="modalIdProof" href="#" target="_blank" class="text-blue-500 underline">View ID Proof</a>
            <p id="idProofStatus" class="text-xs mt-1"></p>
        </div>

        <div class="mb-4">
            <h3 class="text-sm font-semibold">Address Proof:</h3>
            <a id="modalAddressProof" href="#" target="_blank" class="text-blue-500 underline">View Address Proof</a>
            <p id="addressProofStatus" class="text-xs mt-1"></p>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between mt-4">
            <button id="approveProof" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Approve</button>
            <button id="rejectProof" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Reject</button>
            <button onclick="closeModal()" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">Close</button>
        </div>
    </div>
</div>
<!-- Edit User Modal -->
<div id="editUserModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-bold mb-2">Edit User</h2>
        <p class="text-gray-700"><strong>Name:</strong> <span id="modalUserName"></span></p>
        <p class="text-gray-700"><strong>Email:</strong> <span id="modalUserEmail"></span></p>
        
        <!-- ID Proof -->
        <div class="mt-4">
            <h3 class="text-sm font-semibold">ID Proof:</h3>
            <img id="modalIdProofImage" src="" alt="ID Proof" class="w-full h-40 object-cover rounded-md shadow">
            <div class="flex justify-between mt-2">
                <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600" onclick="updateProofStatus('id_proof', 'approved')">Approve</button>
                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="updateProofStatus('id_proof', 'rejected')">Reject</button>
            </div>
        </div>

        <!-- Address Proof -->
        <div class="mt-4">
            <h3 class="text-sm font-semibold">Address Proof:</h3>
            <img id="modalAddressProofImage" src="" alt="Address Proof" class="w-full h-40 object-cover rounded-md shadow">
            <div class="flex justify-between mt-2">
                <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600" onclick="updateProofStatus('address_proof', 'approved')">Approve</button>
                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="updateProofStatus('address_proof', 'rejected')">Reject</button>
            </div>
        </div>

        <!-- Close Button -->
        <div class="mt-4 flex justify-end">
            <button onclick="closeEditModal()" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">Close</button>
        </div>
    </div>
</div>


    <script>
        function filterUsers() {
    let email = document.getElementById("emailSearch").value.toLowerCase().trim();
    let status = document.getElementById("statusFilter").value.toLowerCase().trim();
    let rows = document.querySelectorAll("#userTable tr");

    rows.forEach(row => {
        let emailText = row.cells[2].innerText.toLowerCase().trim(); // Ensure correct column
        let statusElement = row.cells[5].querySelector(".status");
        let statusText = statusElement ? statusElement.textContent.toLowerCase().trim() : "";

        let emailMatch = email === "" || emailText.includes(email);
        let statusMatch = status === "" || statusText === status;

        row.style.display = emailMatch && statusMatch ? "" : "none";
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
         document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function () {
                // Get user data from button attributes
                let userId = this.dataset.id;
                let userName = this.dataset.name;
                let userEmail = this.dataset.email;
                let idProof = this.dataset.idproof;
                let addressProof = this.dataset.addressproof;

                // Fill modal fields
                document.getElementById("modalUserName").innerText = userName;
                document.getElementById("modalUserEmail").innerText = userEmail;
                document.getElementById("modalIdProofImage").src = idProof;
                document.getElementById("modalAddressProofImage").src = addressProof;

                // Store userId for updating proof status
                document.getElementById("editUserModal").dataset.userId = userId;

                // Show modal
                document.getElementById("editUserModal").classList.remove("hidden");
            });
        });
    });

    function closeEditModal() {
        document.getElementById("editUserModal").classList.add("hidden");
    }

    function updateProofStatus(proofType, status) {
        let userId = document.getElementById("editUserModal").dataset.userId;

        fetch(`/admin/users/${userId}/update-proof-status`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ proofType: proofType, status: status }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`User's ${proofType.replace("_", " ")} updated to ${status}`);
                closeEditModal();
                location.reload(); // Refresh to update UI
            }
        })
        .catch(error => console.error("Error:", error));
    }
</script>
    </script>
</body>
</html>
