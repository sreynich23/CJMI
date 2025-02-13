<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo.png') }}">
    <title>Admin Dashboard - CJMRI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body class="font-sans bg-gray-50 h-full">
    <div class="flex h-full bg-white">
        <!-- Admin Navigation -->
        <div class="w-full text-gray-700 bg-green-500">
            <div class="flex flex-col max-w-screen-xl text-white mx-auto md:items-center  md:flex-row md:px-2 lg:px-4">
                <div class="">
                    <img src="{{ asset('storage/' . $navbar->logo_path) }}" alt="Logo" height="100"
                        width="100">
                </div>
                <div class="flex flex-row items-center p-4">
                    <a href="#"
                        class="text-lg text-white font-semibold tracking-widest uppercase rounded-lg focus:outline-none focus:shadow-outline">
                        {{ $navbar->title ?? '' }}
                    </a>
                </div>
                <nav class="flex-col flex-grow pb-4 md:pb-0 md:flex md:justify-end md:flex-row">
                    <button onclick="switchScreen('homePage')"
                        class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg hover:text-gray-900 hover:bg-gray-200 focus:outline-none focus:shadow-outline">Home</button>
                    <button onclick="switchScreen('editorailPage')"
                        class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg hover:text-gray-900 hover:bg-gray-200 focus:outline-none focus:shadow-outline">Editorials</button>
                    <button onclick="switchScreen('aboutPage')"
                        class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg hover:text-gray-900 hover:bg-gray-200 focus:outline-none focus:shadow-outline">About</button>
                    <button onclick="switchScreen('announcementPage')"
                        class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg hover:text-gray-900 hover:bg-gray-200 focus:outline-none focus:shadow-outline">Announcements</button>
                    <button onclick="switchScreen('editorialsPage')"
                        class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg hover:text-gray-900 hover:bg-gray-200 focus:outline-none focus:shadow-outline">Editorials Teams</button>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 mt-2 text-sm font-semibold bg-red-500 rounded-lg hover:bg-red-600 focus:outline-none focus:shadow-outline text-white ml-2">
                            Logout
                        </button>
                    </form>

                </nav>
                <div class="flex items-center px-4 py-2 mt-2">
                    <button onclick="showNavbarModal()"
                        class="rounded-md px-1 flex gap-2 border bg-green-500 text-white ">
                        Edit
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Main content -->
            <div id="homePage" class="page">
                @include('admin.homePage')
            </div>
            <div id="editorailPage" class="page hidden">
                @include('admin.pages.submitPage')
            </div>
            <div id="aboutPage" class="page hidden">
                @include('admin.pages.aboutPage')
            </div>
            <div id="announcementPage" class="page hidden">
                @include('admin.pages.announcements')
            </div>
            <div id="editorialsPage" class="page hidden">
                @include('admin.pages.editorials')
            </div>
            <footer class="bg-gray-900 text-white py-4">
                <div class="container mx-auto px-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Contact Information -->
                        <div class="space-y-2">
                            <h3 class="font-bold">{{ $journalInfo->journal_name ?? 'CJMI' }}</h3>
                            <div class="text-sm text-gray-400 space-y-1">
                                <p class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $journalInfo->email ?? 'cjmi.journal@gmail.com' }}
                                </p>
                                <p class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                    </svg>
                                    {{ $journalInfo->telegram ?? '+855 85593115' }}
                                </p>
                                <p class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $journalInfo->editorial_office ?? 'Battabang, Cambodia' }}
                                </p>
                                <p class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                    </svg>
                                    <span>Designed by: <strong>Rous Sinin</strong></span>
                                    <span>Developed by: <strong>{{ $journalInfo->developer ?? 'LONG SREYNICH' }}</strong></span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start justify-end">
                            <button onclick="showjournalInfoModal()"
                                class="rounded-md px-1 flex gap-2 border border-gray-500 text-white hover:border-gray-700">
                                Edit
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <div id="journalInfo-modal"
        class="hidden fixed z-50 inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-96">
            <h3 class="text-lg font-semibold mb-4">Update Journal Information</h3>
            <form id="journalInfo-form" method="POST" action="{{ route('admin.about.updateJournalInfo') }}">
                @csrf
                <div class="mb-4">
                    <label for="journal_name" class="block text-sm font-medium text-gray-700">Journal Name</label>
                    <input type="text" name="journal_name" id="journal_name"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        value="{{ $journalInfo->journal_name ?? '' }}" required>
                </div>
                <div class="mb-4">
                    <label for="editorial_office" class="block text-sm font-medium text-gray-700">Editorial
                        Office</label>
                    <input type="text" name="editorial_office" id="editorial_office"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        value="{{ $journalInfo->editorial_office ?? '' }}" required>
                </div>
                <div class="mb-4">
                    <label for="telegram" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="telegram" id="telegram"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        value="{{ $journalInfo->telegram ?? '' }}" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="text" name="email" id="email"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        value="{{ $journalInfo->email ?? '' }}" required>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" class="text-gray-700"
                        onclick="closeModal('journalInfo-modal')">Cancel</button>
                    <button type="submit" class="text-white bg-green-600 px-4 py-2 rounded-md">Update</button>
                </div>
            </form>
        </div>
    </div>

    <div id="navbar-modal"
        class="hidden fixed z-50 inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-96">
            <h3 class="text-lg font-semibold mb-4">Update Navbar Information</h3>
            <form id="navbar-form" action="{{ route('admin.navbar.update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                    <input type="file" name="logo" id="logo"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="background_image" class="block text-sm font-medium text-gray-700">Background
                        Image</label>
                    <input type="file" name="background_image" id="background_image"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        value="{{ $navbar->title ?? '' }}">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" class="text-gray-700" onclick="closeModal('navbar-modal')">Cancel</button>
                    <button type="submit" class="text-white bg-green-600 px-4 py-2 rounded-md">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showjournalInfoModal() {
            const journalInfoModal = document.getElementById('journalInfo-modal');
            journalInfoModal.classList.remove('hidden');
        }

        function switchScreen(screenId) {
            document.querySelectorAll('.page').forEach((page) => {
                page.classList.add('hidden');
            });
            document.getElementById(screenId).classList.remove('hidden');
        }

        function showNavbarModal() {
            const navbarModal = document.getElementById('navbar-modal');
            navbarModal.classList.remove('hidden');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
        }
    </script>
</body>

</html>
