<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .relative { position: relative; }
        .absolute { position: absolute; }
    </style>
</head>
<body class="bg-gray-100">
    @include('navbar')

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white py-6">
        <div class="container mx-auto text-center">
            <div class="grid grid-cols-3 gap-4 text-sm">
                <div>
                    <h2 class="font-bold mb-2">Information</h2>
                    <ul>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h2 class="font-bold mb-2">My Account</h2>
                    <ul>
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li><a href="#">Profile</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">Logout</button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
                <div>
                    <h2 class="font-bold mb-2">Extras</h2>
                    <ul>
                        <li><a href="#">Downloads</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Support</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
