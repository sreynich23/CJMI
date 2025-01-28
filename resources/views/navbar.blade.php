<!DOCTYPE html>
<html>

<head>
    <!-- ... other head elements ... -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="text-white">
        <div class="flex justify-end items-center lg:px-9 px-1 py-3 lg:space-x-4 bg-green-600">
            @guest
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <a href="{{ route('register') }}" class="nav-link">Register</a>
            @else
                <div class="flex items-center space-x-4">
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ url('/admin') }}"
                            class="block px-2 py-2 lg:text-sm text-xs text-gray-700 hover:bg-gray-100 rounded-lg bg-white">Admin
                            Dashboard</a>
                    @endif
                    <div class="relative" x-data="{ open: false }">

                        <button @click="open = !open" class="nav-link flex items-center lg:text-sm text-xs">
                            My Account
                            <svg class="ml-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                            <a href="{{ route('profile.show') }}"
                                class="block px-2 py-2 lg:text-sm text-xs text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-2 py-2 lg:text-sm text-xs text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
        <div class="relative px-9 flex justify-between py-5">
            <!-- Blurred Background Image -->
            <div class="absolute inset-0 -z-10"
                style="
                    background-image: url('{{ asset('storage/' . $navbar->background_color) }}');
                    background-size: cover;
                    background-position: center;
                    filter: blur(1px);
                    -webkit-filter: blur(1px);">
            </div>

            <!-- Content (Logo and Title) -->
            @if (isset($navbar))
                <div class="flex items-center">
                    <img src="{{ asset('storage/' . $navbar->logo_path) }}" alt="Logo"
                        class="w-full max-w-xs lg:max-w-sm h-auto object-contain">
                </div>
            @endif

            <div class="px-12">
                <h1 class="lg:text-5xl text-sm font-bold">{{ $navbar->title ?? 'CJMRI' }}</h1>
            </div>
        </div>

    </header>
    <nav class="text-white flex py-2 bg-green-600 sticky top-0 justify-between px-1 z-50">
        <ul class="flex flex-wrap justify-center space-x-2 items-center">
            <li>
                <a href="{{ route('home') }}"
                    class="px-3 py-2 lg:text-sm text-xs hover:border hover:rounded hover:bg-green-700">
                    HOME
                </a>
            </li>
            <li>
                <a href="{{ route('curr') }}"
                    class="px-3 py-2 lg:text-sm text-xs hover:border hover:rounded hover:bg-green-700">
                    CURRENT ISSUE
                </a>
            </li>
            <li>
                <a href="{{ route('all_volumes') }}"
                    class="px-3 py-2 lg:text-sm text-xs hover:border hover:rounded hover:bg-green-700">
                    ALL VOLUME ISSUES
                </a>
            </li>
            <li>
                <a href="{{ route('all-editorials') }}"
                    class="px-3 py-2 lg:text-sm text-xs hover:border hover:rounded hover:bg-green-700">
                    EDITORIAL POLICIES
                </a>
            </li>
            <li>
                <a href="{{ route('announcements') }}"
                    class="px-3 py-2 lg:text-sm text-xs hover:border hover:rounded hover:bg-green-700">
                    ANNOUNCEMENTS
                </a>
            </li>
            <li>
                <a href="{{ route('submit.index') }}"
                    class="px-3 py-2 lg:text-sm text-xs hover:border hover:rounded hover:bg-green-700">
                    SUBMISSION
                </a>
            </li>
            <li>
                <a href="{{ route('about') }}"
                    class="px-3 py-2 lg:text-sm text-xs hover:border hover:rounded hover:bg-green-700">
                    ABOUT
                </a>
            </li>
            @guest
            @else
                @if (auth()->user()->role === 'reviewer')
                    <li>
                        <a href="{{ route('reviewer') }}"
                            class="px-3 py-2 lg:text-sm text-xs hover:border hover:rounded hover:bg-green-700">
                            REVIEWER
                        </a>
                    </li>
                @endif
            @endguest
        </ul>
        <!-- Search Form Section -->
        <form action="{{ route('home') }}" method="GET" class="flex flex-1 gap-2 items-center px-1">
            <input type="text" name="query"
                class="text-black w-16 lg:w-40 h-8 px-2 lg:text-sm text-xs rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500"
                placeholder="Search..." value="{{ request()->query('query') }}">
            <button type="submit"
                class="px-3 py-1 rounded-md text-xs bg-blue-500 hover:bg-blue-600 transition-colors w-16 lg:w-20">
                Search
            </button>
        </form>

    </nav>


</body>

</html>
