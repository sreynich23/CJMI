<div class="border rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">All Submissions</h2>

    @if ($submissions->isEmpty())
        <p class="text-gray-500">No submissions found.</p>
    @else
        <div class="overflow-x-auto">
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
                                <a href="{{ $submission->getFileUrl() }}" class="text-blue-600 hover:text-blue-900" target="_blank">
                                    Download
                                </a>
                                <span class="text-xs text-gray-500 block">
                                    {{ $submission->file_type }} - {{ number_format($submission->file_size / 1024, 2) }} KB
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $submission->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $submission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($submission->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <div class="flex space-x-3">
                                    @if ($submission->status === 'pending')
                                        <button onclick="openModal('approve', {{ $submission->id }}, '{{ route('admin.submissions.approve', ':id') }}')" class="text-green-600 hover:text-green-900">Approve</button>
                                        <button onclick="openModal('reject', {{ $submission->id }}, '{{ route('admin.submissions.reject', ':id') }}')" class="text-red-600 hover:text-red-900">Reject</button>

                                        <!-- Reviewers Dropdown -->
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" type="button" class="text-gray-400 hover:text-gray-600">Select Reviewers</button>
                                            <div x-show="open" @click.away="open = false" class="fixed top-auto  mt-2 w-60 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                                <div class="py-1">
                                                    @foreach (['Long Sreynich', 'Dalin', 'Sinin'] as $reviewer)
                                                        <div class="flex items-center px-4 py-2">
                                                            <input type="checkbox" name="reviewers[]" value="{{ $reviewer }}" class="form-checkbox h-4 w-4 text-blue-600 rounded" id="reviewer-{{ $reviewer }}">
                                                            <label for="reviewer-{{ $reviewer }}" class="ml-2 text-sm text-gray-700">{{ $reviewer }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button type="button" @click="open = false" class=" text-black py-2 px-4 rounded-md">
                                                    Cancel
                                                </button>
                                                <button type="submit" class=" text-green-500 py-2 px-4 rounded-md text-sm">
                                                    Submit Application
                                                </button>
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

<!-- Modals -->
<div id="modal-container" class="hidden fixed z-50 inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4" id="modal-title">Modal Title</h3>
        <form id="modal-form" method="POST">
            @csrf
            <input type="hidden" name="submission_id" id="modal-submission-id">
            <div id="modal-fields"></div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="text-gray-700" onclick="closeModal()">Cancel</button>
                <button type="submit" class="text-white bg-green-600 px-4 py-2 rounded-md">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(type, submissionId, route) {
        const modal = document.getElementById('modal-container');
        const modalForm = document.getElementById('modal-form');
        const modalTitle = document.getElementById('modal-title');
        const modalFields = document.getElementById('modal-fields');

        modalForm.action = route.replace(':id', submissionId);
        modalTitle.innerText = type === 'approve' ? 'Approve Submission' : 'Reject Submission';

        modalFields.innerHTML = type === 'approve'
            ? `<div class="mb-4"><label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                 <input type="text" name="year" id="year" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
               <div class="mb-4"><label for="volume" class="block text-sm font-medium text-gray-700">Volume</label>
                 <input type="text" name="volume" id="volume" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
               <div class="mb-4"><label for="issue" class="block text-sm font-medium text-gray-700">Issue</label>
                 <input type="text" name="issue" id="issue" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>`
            : `<div class="mb-4"><label for="reason" class="block text-sm font-medium text-gray-700">Reason for Rejection</label>
                 <textarea name="reason" id="reason" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea></div>`;

        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal-container').classList.add('hidden');
    }
</script>
