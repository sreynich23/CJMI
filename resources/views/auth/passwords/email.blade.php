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
            <form action="{{ route('send-otp') }}" method="POST" class="space-y-4">
                @csrf
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border px-3 border-gray-300 shadow-sm focus:border-green-700 focus:ring-green-700">
                <button type="submit" class="w-full bg-green-700 text-white p-2 rounded">
                    Send OTP
                </button>
            </form>
        </div>
    </div>
</body>

</html>
