<!DOCTYPE html>
<html>

<head>
    <!-- ... other head elements ... -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        <div class="flex justify-between">
            <img src="{{ asset('storage/' . $navbar->background_color) }}" alt="">
        </div>
    </header>
    <nav class="text-white flex py-2 bg-blue-950 sticky top-0 justify-between px-1">
        <ul class="flex flex-wrap justify-center space-x-2 items-center">
            <li>
                <a href="{{ route('home') }}"
                    class="px-3 py-2 text-xs md:text-sm lg:text-base hover:border hover:rounded ">
                    HOME
                </a>
            </li>
            <li>
                <a href="{{ route('about') }}"
                    class="px-3 py-2 text-xs md:text-sm lg:text-base hover:border hover:rounded ">
                    ABOUT
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
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="nav-link flex items-center text-xs md:text-sm lg:text-base">
                        EDITORIAL POLICIES
                        <svg class="ml-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 lg:mt-2 lg:w-48 bg-white rounded-md shadow-lg py-1 z-10">
                        <a href="{{ route('all-editorials') }}#all-editorials"
                            class="block px-2 py-2 text-xs md:text-sm lg:text-base text-gray-700 hover:text-white hover:bg-blue-950">
                            📖 All Editorials
                        </a>
                        <a href="{{ route('all-editorials') }}#reviewing-policy"
                            class="block px-2 py-2 text-xs md:text-sm lg:text-base text-gray-700 hover:text-white hover:bg-blue-950">
                            📝 Reviewing Policy
                        </a>
                        <a href="{{ route('all-editorials') }}#archiving-policy"
                            class="block px-2 py-2 text-xs md:text-sm lg:text-base text-gray-700 hover:text-white hover:bg-blue-950">
                            📂 Archiving Policy
                        </a>
                        <a href="{{ route('all-editorials') }}#plagiarism-policy"
                            class="block px-2 py-2 text-xs md:text-sm lg:text-base text-gray-700 hover:text-white hover:bg-blue-950">
                            📑 Plagiarism Policy
                        </a>
                        <a href="{{ route('all-editorials') }}#open-access-policy"
                            class="block px-2 py-2 text-xs md:text-sm lg:text-base text-gray-700 hover:text-white hover:bg-blue-950">
                            🔓 Open Access Policy
                        </a>
                    </div>
                </div>
                {{-- <a href="{{ route('all-editorials') }}"
                    class="px-3 py-2 lg:text-sm text-xs hover:border hover:rounded ">
                    EDITORIAL POLICIES
                </a> --}}
            </li>
            <li>
                <a href="{{ route('submit.index') }}"
                    class="px-3 py-2 text-xs md:text-sm lg:text-base hover:border hover:rounded ">
                    SUBMISSION
                </a>
            </li>
            <li>
                <a href="{{ route('announcements') }}"
                    class="px-3 py-2 text-xs md:text-sm lg:text-base hover:border hover:rounded ">
                    ANNOUNCEMENTS
                </a>
            </li>
            @guest
            @else
                @if (auth()->user()->role === 'reviewer')
                    <li>
                        <a href="{{ route('reviewer') }}"
                            class="px-3 py-2 lg:text-sm text-xs hover:border hover:rounded ">
                            FOR REVIEWER
                        </a>
                    </li>
                @endif
            @endguest
        </ul>

    </nav>


</body>

</html>
