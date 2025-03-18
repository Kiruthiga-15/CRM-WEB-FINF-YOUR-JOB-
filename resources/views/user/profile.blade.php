@if($user->id_proof_status == 'rejected' || $user->address_proof_status == 'rejected')
    <form action="{{ route('users.reupload-proof') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        @if($user->id_proof_status == 'rejected')
        <label for="id_proof_reupload">Reupload ID Proof:</label>
        <input type="file" name="id_proof_reupload" required class="block border p-2 rounded w-full">
        @endif

        @if($user->address_proof_status == 'rejected')
        <label for="address_proof_reupload">Reupload Address Proof:</label>
        <input type="file" name="address_proof_reupload" required class="block border p-2 rounded w-full">
        @endif

        <button type="submit" class="mt-3 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Submit Reupload
        </button>
    </form>
@endif
