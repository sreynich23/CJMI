<aside class="p-2 flex bg-white gap-5">
    <!-- Sidebar -->
    <div class=" sticky top-4 h-screen overflow-y-auto">
        <div class="flex items-end justify-end mb-4">
            <!-- Main Content -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex">
                <!-- Header -->
                <div class="p-6 border-b">
                    <h1 class="text-2xl font-bold">Announcements</h1>
                    <!-- Button to show the form -->
                    <button onclick="showannouncementsModal()"
                        class="rounded-md px-1 flex gap-2 border border-gray-500  hover:border-gray-700">
                        Edit
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z" />
                        </svg>
                    </button>
                </div>
                <!-- Main Content -->
                <div class="p-6">
                    <!-- Featured Announcement -->
                    <div class="mb-8 bg-white rounded-lg border p-6">
                        <h2 class="text-xl font-bold mb-2">Call for Papers</h2>
                        <div class="text-gray-600 mb-2">{{$announcements->updated_at}}</div>
                        <div class="prose max-w-none">
                            <h3 class="text-lg font-semibold mb-2">Cambodian Journal of Multidisciplinary Research and Innovation (CJMRI)</h3>
                            <div class="flex items-center space-x-4">
                                <p>{{$announcements->content}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</aside>

<!-- Hidden Form Section -->
<div id="announcements-modal"
    class="hidden fixed z-50 inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-4/5">
        <h3 class="text-lg font-semibold mb-4">Update Journal Information</h3>
        <form id="announcements-form" method="POST" action="{{ route('admin.about.updateAnnouncements') }}">
            @csrf
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea name="content" id="content" rows="10"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-lg py-3" required>{{ $announcements->content ?? '' }}</textarea>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="text-gray-700" onclick="closeModal('announcements-modal')">Cancel</button>
                <button type="submit" class="text-white bg-green-600 px-4 py-2 rounded-md">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showannouncementsModal() {
        const announcementsModal = document.getElementById('announcements-modal');
        announcementsModal.classList.remove('hidden');
    }

    function switchScreen(screenId) {
        document.querySelectorAll('.page').forEach((page) => {
            page.classList.add('hidden');
        });
        document.getElementById(screenId).classList.remove('hidden');
    }
</script>
