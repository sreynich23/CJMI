<!DOCTYPE html>
<html>

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body>
    <header class="text-white">
        <div class="flex justify-end items-center lg:px-9 px-1 py-3 space-x-4 lg:space-x-5 bg-blue-950">
            @guest
                <a href="{{ route('login') }}" class="nav-link text-xs md:text-sm lg:text-base">Login</a>
                <a href="{{ route('register') }}" class="nav-link text-xs md:text-sm lg:text-base">Register</a>
            @else
                <div class="flex items-center space-x-4">
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ url('/admin') }}"
                            class="block px-2 py-2 lg:text-sm text-xs text-gray-700 hover:bg-gray-100 rounded-lg bg-white">Editorial
                            Dashboard</a>
                    @endif
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="nav-link flex items-center lg:text-sm text-xs">
                            My Account
                            <svg class="ml-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-cloak x-show="open" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                            <a href="{{ route('profile.show') }}"
                                class="block px-2 py-2 lg:text-sm text-xs text-gray-700 hover:bg-gray-100">
                                Profile
                            </a>
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
        <div class="flex justify-between">
            @if(Storage::exists('public/' . $navbar->background_color))
                <img src="{{ asset('storage/' . $navbar->background_color) }}" alt="">
            @else
                <img src="{{ asset('storage/images/aWUzD1MBfnyxCuDGFFzQOIJKgLfBzbfu9Cs4dnam.png') }}" alt="">
            @endif
        </div>
    </header>
    <nav class="text-white flex py-2 bg-blue-950 sticky top-0 justify-between px-1 z-20">
        <ul class="flex flex-wrap justify-center space-x-2 items-center">
            <li>
                <a href="{{ route('home') }}"
                    class="px-2 py-2 text-xs md:text-sm lg:text-base hover:border hover:rounded ">
                    HOME
                </a>
            </li>
            <li>
                <a href="{{ route('about') }}"
                    class="px-2 py-2 text-xs md:text-sm lg:text-base hover:border hover:rounded ">
                    ABOUT CJMRI
                </a>
            </li>
            <li>
                <a href="{{ route('curr') }}"
                    class="px-3 py-2 text-xs md:text-sm lg:text-base hover:border hover:rounded ">
                    CURRENT ISSUE
                </a>
            </li>
            <li>
                <a href="{{ route('all_volumes') }}"
                    class="px-3 py-2 text-xs md:text-sm lg:text-base hover:border hover:rounded ">
                    ALL VOLUME ISSUES
                </a>
            </li>
            <li>
                <a href="{{ route('all-editorials') }}"
                class="px-3 py-2 text-xs md:text-sm lg:text-base hover:border hover:rounded ">
                    POLICIES AND GUIDELINES
                </a>
            </li>
            <li>
                <a href="{{ route('editorials-team') }}"
                class="px-2 py-2 text-xs md:text-sm lg:text-base hover:border hover:rounded ">
                EDITORIAL TEAM
                </a>
            </li>
            <li>
                <a href="{{ route('submit.index') }}"
                    class="px-2 py-2 text-xs md:text-sm lg:text-base hover:border hover:rounded ">
                    SUBMISSION
                </a>
            </li>
            <li>
                <a href="{{ route('announcements') }}"
                    class="px-2 py-2 text-xs md:text-sm lg:text-base hover:border hover:rounded ">
                    ANNOUNCEMENTS
                </a>
            </li>
            @guest
            @else
                @if (auth()->user()->role === 'reviewer')
                    <li>
                        <a href="{{ route('reviewer') }}"
                            class="px-2 py-2 lg:text-sm text-xs hover:border hover:rounded ">
                            FOR REVIEWER
                        </a>
                    </li>
                @endif
            @endguest
        </ul>

    </nav>


</body>

</html>
