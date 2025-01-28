<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forget Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-6 space-y-6">
        <div class="max-w-md w-full bg-white rounded-lg shadow-md overflow-hidden  p-6 space-y-6">
            <form action="{{ route('reset-password') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">
                <label for="otp">OTP</label>
                <input type="text" name="otp" id="otp" required class="block w-full border rounded p-2">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" required class="block w-full border rounded p-2">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="block w-full border rounded p-2">
                <button type="submit" class="w-full bg-green-700 text-white p-2 rounded">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</body>
