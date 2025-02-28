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
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
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
                                    <a href="{{ route('admin.download', $submissionsUpdates->id) }}"
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
                                            onclick="openModals('approve', {{ $submissionsUpdates->id }}, '{{ route('admin.submissions.approve', ':id') }}')"
                                            class="text-green-600 hover:text-green-900">Approve</button>
                                        <button
                                            onclick="openModals('reject', {{ $submissionsUpdates->id }}, '{{ route('admin.submissions.reject', ':id') }}')"
                                            class="text-red-600 hover:text-red-900">Reject</button>
                                        <button
                                            onclick="openModalFeedBack({{ $submissionsUpdates->user->id }}, {{ $submissionsUpdates->id }})"
                                            class="text-gray-600 hover:text-gray-900">Request
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
            @if ($image)
                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Cover Image">
            @else
                <p>No image available</p>
            @endif
            <!-- Form for uploading Recognitions -->
            <button type="button" id="uploadRecognitionBtn"
                class="bg-blue-950 h-10 px-3 justify-start items-center flex text-white mt-2">
                Add Recognitions
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </button>
            <form action="{{ route('admin.uploadRecognitions') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Hidden file input -->
                <div id="uploadRecognitions" class="hidden mb-4 space-y-2">
                    <input type="file" name="logo" accept="image/*" class="border border-gray-300 p-2 w-full">
                    <input type="text" name="name" placeholder="name" class="border border-gray-300 p-2 w-full">
                    <input type="text" name="url" placeholder="link" class="border border-gray-300 p-2 w-full">
                    <button type="submit"
                        class="flex rounded-md px-1 gap-2 border border-gray-500 hover:border-gray-700 mb-4">
                        Upload
                    </button>
                </div>
            </form>
            <!-- Form for uploading Indexing -->
            <button type="button" id="uploadIndexingsBtn"
                class="bg-blue-950 h-10 px-3 justify-start items-center flex text-white mt-2">
                Add Indexings
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </button>
            <form action="{{ route('admin.uploadIndexings') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Hidden file input -->
                <div id="uploadIndexings" class="hidden mb-4 space-y-2">
                    <input type="file" name="logo" accept="image/*" class="border border-gray-300 p-2 w-full">
                    <input type="text" name="name" placeholder="name" class="border border-gray-300 p-2 w-full">
                    <input type="text" name="url" placeholder="link" class="border border-gray-300 p-2 w-full">
                    <button type="submit"
                        class="bg-blue-950 h-10 px-3 justify-start items-center flex">
                        Upload
                    </button>
                </div>
            </form>
            <!-- Form for uploading Conferences -->
            <button type="button" id="uploadConferencesBtn"
                class="bg-blue-950 h-10 px-3 justify-start items-center flex text-white my-2">
                Add Conferences
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </button>
            <form action="{{ route('admin.uploadConferences') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Hidden file input -->
                <div id="uploadConferences" class="hidden mb-4 space-y-2">
                    <input type="file" name="logo" accept="image/*" class="border border-gray-300 p-2 w-full">
                    <input type="text" name="name" placeholder="name"
                        class="border border-gray-300 p-2 w-full">
                    <input type="text" name="url" placeholder="link"
                        class="border border-gray-300 p-2 w-full">
                    <button type="submit"
                        class="flex rounded-md px-1 gap-2 border border-gray-500 hover:border-gray-700 mb-4">
                        Upload
                    </button>
                </div>
            </form>

            <!-- Success message -->
            @if (session('success'))
                <div class="bg-green-200 text-green-800 p-4 rounded-md mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display uploaded cover image if available -->
            <div class="sticky top-4 flex flex-col space-y-4">
                <div class="bg-blue-950 h-10 px-3 justify-start items-center flex">
                    <h1 class="text-white text-xs font-semibold">Government, Ministry, and Institution Recognition
                    </h1>
                </div>
                @if ($recognitions)
                    @foreach ($recognitions as $recognition)
                        <div class="flex items-center space-x-2">
                            <img class="h-8 w-auto" src="{{ asset('storage/' . $recognition->logo) }}"
                                alt="{{ $recognition->url }}">
                            <h1 class="text-xs text-white">{{ $recognition->name }}</h1>
                        </div>
                    @endforeach
                @endif
                <div class="bg-blue-950 h-10 px-3 justify-start items-center flex">
                    <h1 class="text-white text-xs font-semibold">Indexing</h1>
                </div>
                @if ($indexings)
                    @foreach ($indexings as $indexing)
                        <img class="h-8 w-auto" src="{{ asset('storage/' . $indexing->logo) }}"
                            alt="{{ $indexing->url }}">
                    @endforeach
                @endif
                <div class="bg-blue-950 h-10 px-3 justify-start items-center flex">
                    <h1 class="text-white text-xs font-semibold">International Conference</h1>
                </div>
                @if ($conferences)
                    @foreach ($conferences as $conference)
                        <img class="h-8 w-auto" src="{{ asset('storage/' . $conference->logo) }}"
                            alt="{{ $conference->url }}">
                    @endforeach
                @endif
            </div>
            <button type="button" id="changePassBtn"
                class="flex rounded-md px-1 gap-2 border border-gray-500 hover:border-gray-700 mt-4">
                Change Password
            </button>
            <form method="POST" action="{{ route('admin.change.password') }}" id="changePass" class="hidden space-y-2 border px-10 py-5 rounded-sm mt-5">
                @csrf
                <div class="form-group">
                    <label for="old_password">Old Password:</label>
                    <input type="password" id="old_password" name="old_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation">Confirm New Password:</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>
                <button type="submit" class="flex rounded-md px-1 gap-2 border border-gray-500 hover:border-gray-700 mb-4">Change Password</button>
            </form>
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
                <button type="button" id="closeModalButtons"
                    class="text-gray-600 hover:text-gray-900">Cancel</button>
                <!-- Submit Button -->
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md">Send
                    Feedback</button>
            </div>
        </form>
    </div>
</div>

<!-- Modals -->
<div id="modal-containers"
    class="hidden fixed z-50 inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4" id="modal-title">Modal Title</h3>
        <form id="modal-forms" method="POST">
            @csrf
            <input type="hidden" name="submission_id" id="modal-submission-id">
            <div id="modal-fields"></div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="text-gray-700" onclick="closeModalSubmits()">Cancel</button>
                <button type="submit" class="text-white bg-green-600 px-4 py-2 rounded-md">Submit</button>
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
        closeModalButtons.addEventListener('click', function() {
            feedbackModals.classList.add('hidden');
        });

        // Close the modal when clicking outside the modal content
        feedbackModals.addEventListener('click', function(event) {
            if (event.target === feedbackModals) {
                feedbackModals.classList.add('hidden');
            }
        });
    }

    document.getElementById('changePassBtn').addEventListener('click', function() {
        var fileInputDiv = document.getElementById('changePass');
        fileInputDiv.classList.toggle('hidden');
    });
    document.getElementById('uploadRecognitionBtn').addEventListener('click', function() {
        var fileInputDiv = document.getElementById('uploadRecognitions');
        fileInputDiv.classList.toggle('hidden');
    });
    document.getElementById('uploadIndexingsBtn').addEventListener('click', function() {
        var fileInputDiv = document.getElementById('uploadIndexings');
        fileInputDiv.classList.toggle('hidden');
    });
    document.getElementById('uploadConferencesBtn').addEventListener('click', function() {
        var fileInputDiv = document.getElementById('uploadConferences');
        fileInputDiv.classList.toggle('hidden');
    });

    function openModals(type, submissionId, route) {
        const modal = document.getElementById('modal-containers');
        const modalForm = document.getElementById('modal-forms');
        const modalTitle = document.getElementById('modal-title');
        const modalFields = document.getElementById('modal-fields');

        modalForm.action = route.replace(':id', submissionId);
        modalTitle.innerText = type === 'approve' ? 'Approve Submission' : 'Reject Submission';

        modalFields.innerHTML = type === 'approve' ?
            `<div class="mb-4"></div>` :
            `<div class="mb-4"><label for="reason" class="block text-sm font-medium text-gray-700">Reason for Rejection</label>
                 <textarea name="reason" id="reason" rows="4" class="mt-1 block w-full border rounded-md shadow-sm"></textarea></div>`;

        modal.classList.remove('hidden');
    }

    function closeModalSubmits() {
        document.getElementById('modal-containers').classList.add('hidden');
    }
</script>
