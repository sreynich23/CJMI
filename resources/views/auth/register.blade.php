<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="max-w-md w-full p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Register</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 rounded-md bg-red-50 border border-red-500">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @if ($errors->has('general'))
                            <li>{{ $errors->first('general') }}</li>
                        @else
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name"
                        value="{{ old('name') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-700 focus:ring-green-700 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email"
                        value="{{ old('email') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-700 focus:ring-green-700 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-700 focus:ring-green-700">
                    <p class="mt-1 text-sm text-gray-500">Password must be at least 8 characters and contain both letters and numbers.</p>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-700 focus:ring-green-700">
                </div>

                <div>
                    <button type="submit" class="w-full py-2 px-4 bg-green-700 text-white rounded-md hover:bg-green-800">
                        Register
                    </button>
                </div>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="text-green-700 hover:text-green-800">Login here</a>
            </p>
        </div>
    </div>
</body>
</html>
