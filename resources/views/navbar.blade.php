<!DOCTYPE html>
<html>

<head>
    <!-- ... other head elements ... -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="text-white bg-green-500">
        <div class="px-9 flex justify-between items-center">
            @if(isset($navbar))
                <img src="{{ asset('storage/' . $navbar->logo_path) }}" alt="Logo" height="100" width="100">
            @endif
            <nav class=" text-white flex px-14 mx-10 py-3 rounded-t-md" >
                <ul class="flex justify-center space-x-4">
                    <li>
                        <a href="{{ route('home') }}" class="px-4 py-2 hover:border hover:rounded text-white ">
                            HOME
                        </a>
                    </li>
                    <li class="relative px-4 text-white" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center">
                            CURRENT
                            <svg class="ml-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        @if(isset($latestYear))
                            <div x-show="open" @click.away="open = false"
                                class="absolute left-0 mt-1 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                <a href="{{ route('curr', ['issue' => 1, 'volume' => 1, 'year' => $latestYear]) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Current Issue
                                </a>
                                <a href="{{ route('all_volumes') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    All Volume Issues
                                </a>
                            </div>
                        @endif
                    </li>
                    <li>
                        <a href="{{ route('announcements') }}" class="px-4 py-2 hover:border hover:rounded text-white">
                            ANNOUNCEMENTS
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('submit.index') }}" class="px-4 py-2 hover:border hover:rounded text-white">
                            SUBMIT
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="px-4 py-2 hover:border hover:rounded text-white">
                            ABOUT
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reviewer') }}" class="px-4 py-2 hover:border hover:rounded text-white">
                            REVIEWER
                        </a>
                    </li>
                    <!-- Search Form Section -->
                    <form action="{{ route('home') }}" method="GET" class="flex justify-center gap-2">
                    <input type="text" name="query"
                        class="text-black min-w-40 h-10 px-4 rounded-md border border-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Search Articles..." value="{{ request()->query('query') }}">
                    <button type="submit" class="w-full bg--500 text-white py-2 rounded-md bg-blue-500">
                        Search
                    </button>
                </form>
                </ul>
            </nav>
            <div>
                @guest
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                @else
                    <div class="flex items-center space-x-4">
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ url('/admin') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg bg-white">Admin
                                Dashboard</a>
                        @endif
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
                                <a href="{{ route('profile.show') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
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
        </div>
    </header>

</body>

</html>
