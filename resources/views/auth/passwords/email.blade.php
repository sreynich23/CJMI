<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forget Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <form action="{{ route('send-otp') }}" method="POST" class="space-y-4">
        @csrf
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required class="block w-full border rounded p-2">
        <button type="submit" class="w-full bg-green-700 text-white p-2 rounded">
            Send OTP
        </button>
    </form>
</body>
</html>
