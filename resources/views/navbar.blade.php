<!DOCTYPE html>
<html>

<head>
    <!-- ... other head elements ... -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="bg-green-500 text-white">
        <div class="p-9 flex justify-between items-center">
            <div class="text-3xl font-bold">Cambodian Journal of Multidisciplinary Research and Innovation (CJMI)</div>
            <div class="flex space-x-4">
            </div>
            <div>
                @guest
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="nav-link flex items-center">
                            My Account
                            <svg class="ml-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
        <nav class="bg-black text-white flex px-14 mx-10 py-3 rounded-t-md">
            <ul class="flex justify-center space-x-4">
                <li>
                    <a href="{{ route('home') }}"
                        class="px-4 py-2 border rounded text-white hover:bg-white hover:text-black">
                        HOME
                    </a>
                </li>
                <li>
                    <a href="{{ route('curr') }}"
                        class="px-4 py-2 border rounded text-white hover:bg-white hover:text-black">
                        CURRENT
                    </a>
                </li>
                <li>
                    <a href="{{ route('announcements') }}"
                        class="px-4 py-2 border rounded text-white hover:bg-white hover:text-black">
                        ANNOUNCEMENTS
                    </a>
                </li>
                <li>
                    <a href="{{ route('submit.index') }}"
                        class="px-4 py-2 border rounded text-white hover:bg-white hover:text-black">
                        SUBMIT
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}"
                        class="px-4 py-2 border rounded text-white hover:bg-white hover:text-black">
                        ABOUT
                    </a>
                </li>
            </ul>
        </nav>
    </header>

</body>

</html>
