<div class="border rounded-lg p-6">

    <h2 class="text-xl font-semibold mb-4">All Submissions</h2>

    @if ($submissions->isEmpty())
        <p class="text-gray-500">No submissions found.</p>
    @else
        <div class="">
            <!-- Submissions Table -->
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($submissions as $submission)
                        <tr>
                            <td class="px-6 py-4">{{ $submission->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $submission->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ $submission->getFileUrl() }}" class="text-blue-600 hover:text-blue-900"
                                    target="_blank">
                                    Download
                                </a>
                                <span class="text-xs text-gray-500 block">
                                    {{ $submission->file_type }} - {{ number_format($submission->file_size / 1024, 2) }}
                                    KB
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $submission->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $submission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($submission->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <div class="flex space-x-3 items-center">
                                    @if ($submission->status === 'pending')
                                        <form
                                            action="{{ route('admin.accept.send', ['authorId' => $submission->user->id, 'submissionId' => $submission->id]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900"
                                                style="background: none; border: none; padding: 0; cursor: pointer;">
                                                Approve
                                            </button>
                                        </form>

                                        <button
                                            onclick="openModalReject({{ $submission->user->id }}, {{ $submission->id }})"
                                            class="text-red-600 hover:text-red-900">Reject</button>
                                        <!-- Reviewers Dropdown -->
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" type="button"
                                                class="text-gray-400 hover:text-gray-600 flex">
                                                Select Reviewers
                                                <svg class="ml-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.away="open = false"
                                                class="absolute left-3 transform -translate-x-full mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                                <form action="{{ route('admin.reviewers.assign') }}" method="POST">
                                                    @csrf
                                                    <!-- Hidden field for the article ID -->
                                                    <input type="hidden" name="submission_id"
                                                        value="{{ $submission->id }}">

                                                    <div class="py-1">
                                                        @foreach ($reviewers as $reviewer)
                                                            <div class="flex items-center px-4 py-2">
                                                                <input type="checkbox" name="reviewers[]"
                                                                    value="{{ $reviewer->id }}"
                                                                    class="form-checkbox text-blue-600 rounded"
                                                                    id="reviewer-{{ $reviewer->id }}">
                                                                <label for="reviewer-{{ $reviewer->id }}"
                                                                    class="ml-2 text-sm text-gray-700">{{ $reviewer->name }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="flex justify-end space-x-2 mt-4 px-4">
                                                        <button type="button" @click="open = false"
                                                            class="text-black py-2 px-4 rounded-md">
                                                            Cancel
                                                        </button>
                                                        <button type="submit"
                                                            class="text-green-500 py-2 px-4 rounded-md text-sm">
                                                            Submit Application
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $submissions->links() }}</div>
    @endif
</div>
<div>

    <h2 class="text-xl font-semibold mb-4">All Submissions Approve</h2>
@if ($submissionsApproved->isEmpty())
@else
    <table class="min-w-full divide-y divide-gray-200 border rounded-lg p-6">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                    Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                    File</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($submissionsApproved as $submissionsApproveds)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $submissionsApproveds->title }}
                    </td>
                    <td class="px-6 py-4">{{ $submissionsApproveds->user->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ 'storage/' . $submissionsApproveds->file_path }}"
                            class="text-blue-600 hover:text-blue-900">
                            Download
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
</div>
<!-- Modal -->
<div id="rejectModals" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-semibold mb-4">Provide Feedback</h2>

        <!-- Feedback Form -->
        <form id="rejectForms" method="POST">
            @csrf
            <div class="form-group mb-4">
                <label for="reason" class="block text-sm font-medium text-gray-700">reason</label>
                <textarea name="reason" id="reason"
                    class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required></textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <!-- Close Button -->
                <button type="button" id="closeModalButtons"
                    class="text-gray-600 hover:text-gray-900">Cancel</button>
                <!-- Submit Button -->
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md">Send
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalReject(userId, submissionId) {
        // Get modal and close button elements
        const rejectModals = document.getElementById('rejectModals');
        const closeModalButtons = document.getElementById('closeModalButtons');

        // Show the modal
        rejectModals.classList.remove('hidden');

        // Set form action dynamically
        const rejectForms = document.getElementById('rejectForms');
        rejectForms.action = `/admin/reject/${userId}/${submissionId}`;

        // Close the modal when the close button is clicked
        closeModalButtons.addEventListener('click', function() {
            rejectModals.classList.add('hidden');
        });

        // Close the modal when clicking outside the modal content
        rejectModals.addEventListener('click', function(event) {
            if (event.target === rejectModals) {
                rejectModals.classList.add('hidden');
            }
        });
    }
</script>
