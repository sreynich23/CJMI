<aside class="p-2 flex bg-white">
    <div class="flex w-full h-screen">
        <!-- Row 1: 3/4 of the screen -->
        <div class="w-4/5 p-6 overflow-y-auto bg-gray-100">
            @if ($submissionsUpdate->isEmpty())
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                File</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($submissionsUpdate as $submissionsUpdates)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $submissionsUpdates->title }}
                                </td>
                                <td class="px-6 py-4">{{ $submissionsUpdates->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ 'storage/' . $submissionsUpdates->file_path }}"
                                        class="text-blue-600 hover:text-blue-900">
                                        Download
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $submissionsUpdates->status }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <button
                                            onclick="openModal('approve', {{ $submissionsUpdates->id }}, '{{ route('admin.submissions.approve', ':id') }}')"
                                            class="text-green-600 hover:text-green-900">Approve</button>
                                        <button
                                            onclick="openModal('reject', {{ $submissionsUpdates->id }}, '{{ route('admin.submissions.reject', ':id') }}')"
                                            class="text-red-600 hover:text-red-900">Reject</button>
                                            <button onclick="openModalFeedBack({{$submissionsUpdates->user->id}}, {{$submissionsUpdates->id}})" class="text-gray-600 hover:text-gray-900">Request
                                                Update</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
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
                @if ($image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Cover Image">
                @else
                    <p>No image available</p>
                @endif
            </div>
        </div>
    </div>
</aside>

<!-- Modal -->
<div id="feedbackModals" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-semibold mb-4">Provide Feedback</h2>

        <!-- Feedback Form -->
        <form id="feedbackForms" method="POST">
            @csrf
            <div class="form-group mb-4">
                <label for="comment" class="block text-sm font-medium text-gray-700">Feedback Comment</label>
                <textarea name="comment" id="comment"
                    class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required></textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <!-- Close Button -->
                <button type="button" id="closeModalButtons" class="text-gray-600 hover:text-gray-900">Cancel</button>
                <!-- Submit Button -->
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md">Send
                    Feedback</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript to toggle file input visibility -->
<script>
    function openModalFeedBack(userId, submissionId) {
        // Get modal and close button elements
        const feedbackModals = document.getElementById('feedbackModals');
        const closeModalButtons = document.getElementById('closeModalButtons');

        // Show the modal
        feedbackModals.classList.remove('hidden');

        // Set form action dynamically
        const feedbackForms = document.getElementById('feedbackForms');
        feedbackForms.action = `/admin/feedback/send/${userId}/${submissionId}`;

        // Close the modal when the close button is clicked
        closeModalButtons.addEventListener('click', function () {
            feedbackModals.classList.add('hidden');
        });

        // Close the modal when clicking outside the modal content
        feedbackModals.addEventListener('click', function (event) {
            if (event.target === feedbackModals) {
                feedbackModals.classList.add('hidden');
            }
        });
    }

    document.getElementById('uploadCoverBtn').addEventListener('click', function() {
        var fileInputDiv = document.getElementById('fileInputDiv');
        fileInputDiv.classList.toggle('hidden');
    });
</script>
