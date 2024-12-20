<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CJMRI</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <div class="flex flex-col max-w-screen-xl text-white px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
                <div class="flex flex-row items-center justify-between p-4">
                    <a href="#" class="text-lg text-white font-semibold tracking-widest uppercase rounded-lg focus:outline-none focus:shadow-outline">
                        Admin Dashboard
                    </a>
                </div>
                <nav class="flex-col flex-grow pb-4 md:pb-0 md:flex md:justify-end md:flex-row">
                    <button onclick="switchScreen('homePage')" class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg hover:text-gray-900 hover:bg-gray-200 focus:outline-none focus:shadow-outline">Home</button>
                    <button onclick="switchScreen('uploadPage')" class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg hover:text-gray-900 hover:bg-gray-200 focus:outline-none focus:shadow-outline">Submit</button>
                    <button onclick="switchScreen('aboutPage')" class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg hover:text-gray-900 hover:bg-gray-200 focus:outline-none focus:shadow-outline">About</button>
                    {{-- <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 mt-2 text-sm font-semibold bg-red-500 rounded-lg hover:bg-red-600 focus:outline-none focus:shadow-outline">
                            Logout
                        </button>
                    </form> --}}
                </nav>
            </div>

            <!-- Main content -->
            <div id="homePage" class="page">
                @include('admin.homePage')
            </div>
            <div id="uploadPage" class="page hidden">
                @include('admin.pages.submitPage')
            </div>
            <div id="aboutPage" class="page hidden">
                @include('admin.pages.aboutPage')
            </div>
        </div>
    </div>

    <script>
        function switchScreen(screenId) {
            document.querySelectorAll('.page').forEach((page) => {
                page.classList.add('hidden');
            });
            document.getElementById(screenId).classList.remove('hidden');
        }
    </script>
</body>
</html>
