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
            <!-- Tab Navigation -->
            <div class="flex border-b">
                <button onclick="switchTab('login')" id="loginTab"
                    class="w-1/2 px-6 py-3 text-center font-semibold text-blue-700 bg-white border-b-2 border-blue-700">
                    Login
                </button>
                <button onclick="switchTab('register')" id="registerTab"
                    class="w-1/2 px-6 py-3 text-center font-semibold text-gray-500 hover:text-blue-700">
                    Register
                </button>
            </div>

            <!-- Login Form -->
            <div id="loginForm" class="p-6 space-y-6">
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="login-email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="login-email" required
                            class="mt-1 block w-full rounded-md border px-3 border-gray-300 shadow-sm focus:border-blue-700 focus:ring-blue-700">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="login-password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="login-password" required
                            class="mt-1 block w-full rounded-md border px-3 border-gray-300 shadow-sm focus:border-blue-700 focus:ring-blue-700">
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember"
                                class="rounded border-gray-300 text-blue-700 focus:ring-blue-700">
                            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                        </div>
                        <div>
                            <a href="{{ route('forgot-password') }}" class="text-sm text-blue-700 hover:underline">Forgot Password?</a>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-2 px-4 bg-blue-700 text-white rounded-md hover:bg-blue-800">
                        Login
                    </button>
                </form>
            </div>

            <!-- Register Form -->
            <div id="registerForm" class="hidden p-6 space-y-6">
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full rounded-md border px-3 border-gray-800 focus:border-blue-700 focus:ring-blue-700">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="register-email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="register-email" value="{{ old('email') }}" required
                            class="mt-1 block w-full rounded-md border px-3 border-gray-800 focus:border-blue-700 focus:ring-blue-700">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="register-password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="register-password" required
                            class="mt-1 block w-full rounded-md border px-3 border-gray-800 focus:border-blue-700 focus:ring-blue-700">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="mt-1 block w-full rounded-md border px-3 border-gray-800 focus:border-blue-700 focus:ring-blue-700">
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

                    <button type="submit"
                        class="w-full py-2 px-4 bg-blue-700 text-white rounded-md hover:bg-blue-800">
                        Register
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            const loginTab = document.getElementById('loginTab');
            const registerTab = document.getElementById('registerTab');
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');

            if (tab === 'login') {
                loginTab.classList.add('text-blue-700', 'border-b-2', 'border-blue-700', 'bg-white');
                loginTab.classList.remove('text-gray-500');
                registerTab.classList.remove('text-blue-700', 'border-b-2', 'border-blue-700', 'bg-white');
                registerTab.classList.add('text-gray-500');
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                window.location.hash = 'login';
            } else {
                registerTab.classList.add('text-blue-700', 'border-b-2', 'border-blue-700', 'bg-white');
                registerTab.classList.remove('text-gray-500');
                loginTab.classList.remove('text-blue-700', 'border-b-2', 'border-blue-700', 'bg-white');
                loginTab.classList.add('text-gray-500');
                registerForm.classList.remove('hidden');
                loginForm.classList.add('hidden');
                window.location.hash = 'register';
            }
        }

        function checkHash() {
            const hash = window.location.hash.replace('#', '') || 'login';
            switchTab(hash);
        }

        checkHash();
        window.addEventListener('hashchange', checkHash);

        const passwordInput = document.getElementById('register-password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        function validatePassword() {
            const password = passwordInput.value;
            const isValid =
                password.length >= 8 &&
                /[A-Z]/.test(password) &&
                /[a-z]/.test(password) &&
                /[0-9]/.test(password) &&
                /[@$!%*#?&]/.test(password);

            passwordInput.style.borderColor = isValid ? '#10B981' : '#EF4444';
        }

        function validateConfirmPassword() {
            const isValid = passwordInput.value === confirmPasswordInput.value;
            confirmPasswordInput.style.borderColor = isValid ? '#10B981' : '#EF4444';
        }

        passwordInput.addEventListener('input', validatePassword);
        confirmPasswordInput.addEventListener('input', validateConfirmPassword);
    </script>
</body>
</html>
