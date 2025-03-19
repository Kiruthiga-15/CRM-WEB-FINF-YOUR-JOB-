<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

</head>
<body class="bg-gradient-to-r from-blue-50 to-purple-100 p-4 md:p-6">
    {{-- <pre>{{ print_r($users->toArray(), true) }}</pre> --}}

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
            @if(session('success'))
    <p>{{ session('success') }}</p>
@endif
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
    <span class="id-proof-status px-2 py-1 rounded-lg text-white text-xs md:text-sm
        @if($user->id_proof_status == 'approved') bg-green-500 
        @elseif($user->id_proof_status == 'pending') bg-yellow-500 
        @else bg-red-500 @endif">
        {{ ucfirst($user->id_proof_status) }}
    </span>
</td>

<td class="border p-2 text-center">
    <span class="address-proof-status px-2 py-1 rounded-lg text-white text-xs md:text-sm
        @if($user->address_proof_status == 'approved') bg-green-500 
        @elseif($user->address_proof_status == 'pending') bg-yellow-500 
        @else bg-red-500 @endif">
        {{ ucfirst($user->address_proof_status) }}
    </span>
</td>

                        <td class="border p-2 font-semibold text-center">
                            <span class="status px-2 py-1 rounded-lg text-white text-xs md:text-sm
                                @if($user->status == 'approved') bg-green-500 @elseif($user->status == 'pending') bg-yellow-500 @else bg-red-500 @endif">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="border p-2 text-center flex flex-col md:flex-row gap-2 justify-center">
 <button class="edit-user bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
    data-user-id="{{ $user->id }}"
    data-user-name="{{ $user->name }}"
    data-user-email="{{ $user->email }}"
    data-id-proof="{{ asset('storage/' . $user->id_proof) }}"
    data-address-proof="{{ asset('storage/' . $user->address_proof) }}">
    Edit
</button>
</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  
<!-- Popup Modal -->
<div id="proofModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <h3 class="text-lg font-bold mb-4">User Proofs</h3>

        <!-- ID Proof Section -->
        <div class="mb-4">
            <p class="font-semibold">ID Proof:</p>
            <img id="idProofImage" src="" class="w-full max-h-60 object-contain border rounded-lg" alt="ID Proof">
            <div class="flex gap-2 mt-2">
                <button id="approveIdProof" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Approve</button>
                <button id="rejectIdProof" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reject</button>
            </div>
        </div>

        <!-- Address Proof Section -->
        <div class="mb-4">
            <p class="font-semibold">Address Proof:</p>
            <img id="addressProofImage" src="" class="w-full max-h-60 object-contain border rounded-lg" alt="Address Proof">
            <div class="flex gap-2 mt-2">
                <button id="approveAddressProof" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Approve</button>
                <button id="rejectAddressProof" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reject</button>
            </div>
        </div>

        <button id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Close</button>
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
}//popup js



$(document).ready(function() {
    let userId;

    $('.edit-user').click(function() {
        userId = $(this).data('user-id');
        let idProof = $(this).data('id-proof');
        let addressProof = $(this).data('address-proof');

        $('#idProofImage').attr('src', idProof);
        $('#addressProofImage').attr('src', addressProof);
        $('#proofModal').removeClass('hidden');
              // Ensure Reject buttons are visible when opening modal
        $('#rejectIdProof').show();
        $('#rejectAddressProof').show();
    });

    $('#closeModal').click(function() {
        $('#proofModal').addClass('hidden');
    });

    function updateProofStatus(proofType, status) {
        $.ajax({
            url: "{{ route('users.update-proof-status') }}",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                user_id: userId,
                proof_type: proofType,
                status: status
            },
           success: function(response) {
    alert(response.message);

    // // Update the status text and color dynamically
    // let statusText = status.charAt(0).toUpperCase() + status.slice(1); // Capitalize first letter
    // let statusElement = $("#idProofStatus_" + userId);

      // Update status in table dynamically
            if (proofType === "id_proof") {
                let idProofStatusElement = $('button[data-user-id="'+ userId +'"]').closest('tr').find('.id-proof-status');
                idProofStatusElement.text(status.charAt(0).toUpperCase() + status.slice(1)); // Capitalize first letter
                idProofStatusElement.removeClass('bg-yellow-500 bg-green-500 bg-red-500');
                idProofStatusElement.addClass(status === 'approved' ? 'bg-green-500' : 'bg-red-500');
                   // Hide Reject button when Approved
                    if (status === 'approved') {
                        $('#rejectIdProof').hide();
                    }
            }
            
            if (proofType === "address_proof") {
                let addressProofStatusElement = $('button[data-user-id="'+ userId +'"]').closest('tr').find('.address-proof-status');
                addressProofStatusElement.text(status.charAt(0).toUpperCase() + status.slice(1)); // Capitalize first letter
                addressProofStatusElement.removeClass('bg-yellow-500 bg-green-500 bg-red-500');
                addressProofStatusElement.addClass(status === 'approved' ? 'bg-green-500' : 'bg-red-500');
                   // Hide Reject button when Approved
                    if (status === 'approved') {
                        $('#rejectAddressProof').hide();
                    }
            }
               // Check if both proofs are approved, then update overall status
                updateOverallStatus(userId);

    // $('#proofModal').addClass('hidden'); // Close modal after approval/rejection
}
,
             error: function(xhr) {
            alert("Error updating proof status. Try again.");
        }
        });
    }

    //add id and address proof status in status column 
      function updateOverallStatus(userId) {
        let row = $('button[data-user-id="'+ userId +'"]').closest('tr');
        let idProofStatus = row.find('.id-proof-status').text().toLowerCase();
        let addressProofStatus = row.find('.address-proof-status').text().toLowerCase();
        let statusElement = row.find('.status');

        // If both proofs are approved, set status to "Approved", otherwise keep it "Pending"
        if (idProofStatus === 'approved' && addressProofStatus === 'approved') {
            statusElement.text('Approved');
            statusElement.removeClass('bg-yellow-500 bg-green-500 bg-red-500');
            statusElement.addClass('bg-green-500');
        } else {
            statusElement.text('Pending');
            statusElement.removeClass('bg-yellow-500 bg-green-500 bg-red-500');
            statusElement.addClass('bg-yellow-500');
        }
    }

    $('#approveIdProof').click(function() {
        updateProofStatus('id_proof', 'approved');
    });

    $('#rejectIdProof').click(function() {
        updateProofStatus('id_proof', 'rejected');
    });

    $('#approveAddressProof').click(function() {
        updateProofStatus('address_proof', 'approved');
    });

    $('#rejectAddressProof').click(function() {
        updateProofStatus('address_proof', 'rejected');
    });
});
    </script>
</body>
</html>
