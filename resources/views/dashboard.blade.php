<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h2>Welcome, {{ Auth::user()->name }}</h2>
    <p>Your proof status: {{ Auth::user()->id_proof_status }}, {{ Auth::user()->address_proof_status }}</p>

    <h3>Reupload Proofs</h3>
    <form action="{{ route('users.reupload-proof') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="id_proof" required><br>
        <input type="file" name="address_proof" required><br>
        <button type="submit">Reupload</button>
    </form>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
