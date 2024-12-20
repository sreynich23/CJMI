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
        <div class="w-1/4  py-10 px-4 bg-gray-100">
            <div class="sticky top-4">
                <img src="https://img.freepik.com/premium-vector/vector-modern-book-cover-design-company-annual-report_812472-595.jpg?w=2000"
                    alt="Book Cover">
            </div>
        </div>
    </div>
</aside>
