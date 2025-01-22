<div class="container h-screen bg-white border border-gray-300 rounded-lg p-6">
    <table class="min-w-full border border-gray-300 divide-y divide-gray-200 rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Reviewers Request</h1>
            <thead class="bg-gray-100">
                <tr>
                    <th>Reviewer Name</th>
                    <th>Reviewer Position</th>
                    <th>Reviewer Expertise</th>
                    <th>Reviewer Country</th>
                    <th>Reviewer Email</th>
                    <th>Reviewer CV</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviewers as $reviewer)
                    @if ($reviewer->active == 0)
                        <!-- Check explicitly for 0 -->
                        <tr data-id="{{ $reviewer->id }}">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $reviewer->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $reviewer->position }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ ucfirst($reviewer->expertise) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ ucfirst($reviewer->country) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ ucfirst($reviewer->email) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <a href="{{ asset('storage/' . $reviewer->cv) }}"
                                    class="text-blue-600 hover:text-blue-900" download>
                                    Download CV
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="admin/reviewer/approve/{{ $reviewer->id }}"
                                    class="text-green-600 hover:text-green-900 rounded-md p-2">
                                    Approve
                                </a>
                                <button onclick="rejectReviewer({{ $reviewer->id }})"
                                    class="text-red-600 hover:text-red-900 rounded-md p-2">
                                    Reject
                                </button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>

    </table>

    <h2 class="text-xl font-semibold mb-4">Editors</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">File</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Reviewer
                </th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($reviewing as $submissionId => $reviews)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $reviews->first()->title }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ 'storage/' . $reviews->first()->file_path }}"
                            class="text-blue-600 hover:text-blue-900">
                            Download
                        </a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        @foreach ($reviews as $review)
                            <span class="block">{{ $review->status }}</span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        @foreach ($reviews as $review)
                            <span class="block">{{ $review->reviewer_name }}</span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 text-sm font-medium">
                        <div class="flex space-x-3">
                            <button
                                onclick="openModal('approve', {{ $submissionId }}, '{{ route('admin.submissions.approve', ':id') }}')"
                                class="text-green-600 hover:text-green-900">Approve</button>
                            <button
                                onclick="openModal('reject', {{ $submissionId }}, '{{ route('admin.submissions.reject', ':id') }}')"
                                class="text-red-600 hover:text-red-900">Reject</button>
                            <button onclick="openModalButton({{$review->user_id}}, {{$submissionId}})" class="text-gray-600 hover:text-gray-900">Request
                                Update</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Modals -->
<div id="modal-container" class="hidden fixed z-50 inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4" id="modal-title">Modal Title</h3>
        <form id="modal-form" method="POST">
            @csrf
            <input type="hidden" name="submission_id" id="modal-submission-id">
            <div id="modal-fields"></div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="text-gray-700" onclick="closeModalSubmit()">Cancel</button>
                <button type="submit" class="text-white bg-green-600 px-4 py-2 rounded-md">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div id="feedbackModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-semibold mb-4">Provide Feedback</h2>

        <!-- Feedback Form -->
        <form id="feedbackForm" method="POST">
            @csrf
            <div class="form-group mb-4">
                <label for="comment" class="block text-sm font-medium text-gray-700">Feedback Comment</label>
                <textarea name="comment" id="comment"
                    class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required></textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <!-- Close Button -->
                <button type="button" id="closeModalButton" class="text-gray-600 hover:text-gray-900">Cancel</button>
                <!-- Submit Button -->
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md">Send
                    Feedback</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalButton(userId, submissionId) {
        // Get modal and close button elements
        const feedbackModal = document.getElementById('feedbackModal');
        const closeModalButton = document.getElementById('closeModalButton');

        // Show the modal
        feedbackModal.classList.remove('hidden');

        // Set form action dynamically
        const feedbackForm = document.getElementById('feedbackForm');
        feedbackForm.action = `/admin/feedback/send/${userId}/${submissionId}`;

        // Close the modal when the close button is clicked
        closeModalButton.addEventListener('click', function () {
            feedbackModal.classList.add('hidden');
        });

        // Close the modal when clicking outside the modal content
        feedbackModal.addEventListener('click', function (event) {
            if (event.target === feedbackModal) {
                feedbackModal.classList.add('hidden');
            }
        });
    }

    function openModal(type, submissionId, route) {
        const modal = document.getElementById('modal-container');
        const modalForm = document.getElementById('modal-form');
        const modalTitle = document.getElementById('modal-title');
        const modalFields = document.getElementById('modal-fields');

        modalForm.action = route.replace(':id', submissionId);
        modalTitle.innerText = type === 'approve' ? 'Approve Submission' : 'Reject Submission';

        modalFields.innerHTML = type === 'approve' ?
            `<div class="mb-4"><label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                 <input type="text" name="year" id="year" class="mt-1 block w-full border rounded-md shadow-sm"></div>
               <div class="mb-4"><label for="volume" class="block text-sm font-medium text-gray-700">Volume</label>
                 <input type="text" name="volume" id="volume" class="mt-1 block w-full border rounded-md shadow-sm"></div>
               <div class="mb-4"><label for="issue" class="block text-sm font-medium text-gray-700">Issue</label>
                 <input type="text" name="issue" id="issue" class="mt-1 block w-full border rounded-md shadow-sm"></div>` :
            `<div class="mb-4"><label for="reason" class="block text-sm font-medium text-gray-700">Reason for Rejection</label>
                 <textarea name="reason" id="reason" rows="4" class="mt-1 block w-full border rounded-md shadow-sm"></textarea></div>`;

        modal.classList.remove('hidden');
    }

    function closeModalSubmit() {
        document.getElementById('modal-container').classList.add('hidden');
    }
</script>
