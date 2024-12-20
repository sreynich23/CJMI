<div class="flex flex-col items-center bg-white p-4 space-x-3 border rounded-lg">
    <!-- Image Section -->
    <div class=" min-w-[100px] w-full">
        <h1 class="text-blue-900 font-medium  mb-2 text-4xl">
            The Importance of Sex Education for Cambodian Students
        </h1>
    </div>
    <!-- Text and Button Section -->
    <div class="flex flex-wrap flex-grow w-full items-center space-x-2 gap-y-4 py-4 px-6 ">
        <div class="flex">
            <!-- Left Arrow -->
            <button class="text-green-700 hover:text-green-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Center Content -->
            <div class="flex-1 flex items-center justify-center space-x-6 overflow-x-auto scrollbar-hide">
                <!-- Current Volume -->
                <span class="font-semibold text-xl text-gray-800">
                    Volume 25, 2024
                </span>

                <!-- Past Volumes -->
                <a href="#" class="text-green-700 hover:underline">Vol 24, 2023</a>
                <a href="#" class="text-green-700 hover:underline">Vol 23, 2022</a>
                <a href="#" class="text-green-700 hover:underline">Vol 22, 2021</a>
            </div>

            <!-- Right Arrow -->
            <button class="text-green-700 hover:text-green-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        <a href="" class=" text-blue-900 hover:underline">All volumes & issues</a>
    </div>



    <div class="container mx-auto p-6 bg-gray-100 border rounded-lg shadow-md">
        <!-- Navigation -->
        <div class="flex items-center space-x-4 mb-4">
            <!-- Left Arrow -->
            <button class="text-gray-700 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Issues -->
            <nav class="flex space-x-6 text-center">
                <a href="#" class="text-green-00 font-bold border-b-2 border-green-700">Issue 5</a>
                <a href="#" class="text-green-700 hover:text-green-00">Issue 4</a>
                <a href="#" class="text-green-700 hover:text-green-00">Issue 3</a>
                <a href="#" class="text-green-700 hover:text-green-00">Issue 2</a>
                <a href="#" class="text-green-700 hover:text-green-00">Issue 1</a>
            </nav>

            <!-- Right Arrow -->
            <button class="text-gray-700 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        @include('wigets.articles')
</div>
</div>
