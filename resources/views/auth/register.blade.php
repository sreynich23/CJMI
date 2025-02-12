<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login & Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow-md overflow-hidden">
        <form method="POST" action="{{ route('register') }}" class="p-6 space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full rounded-md border px-3 border-gray-800  focus:border-blue-700 focus:ring-blue-700">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="register-email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="register-email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-md border px-3 border-gray-800  focus:border-blue-700 focus:ring-blue-700">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="register-password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="register-password" required
                    class="mt-1 block w-full rounded-md border px-3 border-gray-800  focus:border-blue-700 focus:ring-blue-700">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                    Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="mt-1 block w-full rounded-md border px-3 border-gray-800  focus:border-blue-700 focus:ring-blue-700">
            </div>

            <div class="form-group">
                <label for="country">Country</label>
                <select name="country" id="country" class="form-control">
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country['alpha2'] }}">{{ $country['en'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="notifications" id="notifications"
                    class="rounded border-gray-300 text-blue-700 focus:ring-blue-700">
                <label for="notifications" class="ml-2 text-sm text-gray-600">
                    Receive notifications about new publications
                </label>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="reviewer" id="reviewer"
                    class="rounded border-gray-300 text-blue-700 focus:ring-blue-700">
                <label for="reviewer" class="ml-2 text-sm text-gray-600">
                    Available as reviewer
                </label>
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-blue-700 text-white rounded-md hover:bg-blue-800">
                Register
            </button>
        </form>
    </div>
    </div>
</body>

</html>
