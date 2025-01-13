<aside class="p-2 flex bg-white">
    <div class="flex w-full h-screen">
        <!-- Row 1: 3/4 of the screen -->
        <div class="w-4/5 p-6 overflow-y-auto bg-gray-100">
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
        <div class="w-1/5 py-10 px-4 bg-gray-100">
            <!-- Form for uploading cover image -->
            <form action="{{ route('admin.uploadCover') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Button to trigger the file input -->
                <button type="button" id="uploadCoverBtn"
                    class="flex rounded-md px-1 gap-2 border border-gray-500 hover:border-gray-700 mb-4">
                    Add cover
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </button>

                <!-- Hidden file input -->
                <div id="fileInputDiv" class="hidden mb-4">
                    <input type="file" name="cover_image" accept="image/*" class="border border-gray-300 p-2 w-full">
                </div>

                <button type="submit"
                    class="flex rounded-md px-1 gap-2 border border-gray-500 hover:border-gray-700 mb-4">
                    Upload Cover
                </button>
            </form>

            <!-- Success message -->
            @if (session('success'))
                <div class="bg-green-200 text-green-800 p-4 rounded-md mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display uploaded cover image if available -->
                <div class="sticky top-4">
                    @if($image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Cover Image">
                @else
                    <p>No image available</p>
                @endif
                </div>
        </div>
    </div>
</aside>

<!-- JavaScript to toggle file input visibility -->
<script>
    document.getElementById('uploadCoverBtn').addEventListener('click', function() {
        var fileInputDiv = document.getElementById('fileInputDiv');
        fileInputDiv.classList.toggle('hidden');
    });
</script>
