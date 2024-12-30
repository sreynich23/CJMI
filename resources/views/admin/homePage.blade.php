<aside class="p-2 flex bg-white">

    <div class="flex">
        <!-- Row 1: 3/4 of the screen -->
        <div class="w-3/4 p-6 overflow-y-auto bg-gray-100">
            <!-- Title Section -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-semibold text-gray-800">All Submit</h2>
            </div>
            <!-- Item List -->
            <div>
                @include('admin.pages.wigets.listSubmit')
            </div>
            <!-- Title Section -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-semibold text-gray-800">All Volume&Issue</h2>
            </div>
            <!-- Item List -->
            <div>
                @include('admin.pages.wigets.item_list')
            </div>
        </div>
        <!-- Row 2: 1/4 of the screen -->
        <div class="w-1/4  py-10 px-4 bg-gray-100 ">
            <button class="flex rounded-md px-1 gap-2 border border-gray-500  hover:border-gray-700">Add cover<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg></button>
            <div class="sticky top-4">
                <img src="https://img.freepik.com/premium-vector/vector-modern-book-cover-design-company-annual-report_812472-595.jpg?w=2000"
                    alt="Book Cover">
            </div>
        </div>
    </div>
</aside>
