<div class="container h-screen bg-white border border-gray-300 rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Editors</h2>
    <table class="min-w-full border border-gray-300 divide-y divide-gray-200 rounded-lg">
        <thead class="bg-gray-100">
            <tr>
                {{-- <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">#</th> --}}
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Reviewer
                </th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <tr>
                <td></td>
                <td>Status</td>
                <td>Long Sreynich, Dalin, Sinin</td>
                <td>
                    {{-- <button
                        onclick="openModal('approve', {{ $submission->id }}, '{{ route('admin.submissions.approve', ':id') }}')"
                        class="text-green-600 hover:text-green-900">Approve</button>
                    <button
                        onclick="openModal('reject', {{ $submission->id }}, '{{ route('admin.submissions.reject', ':id') }}')"
                        class="text-red-600 hover:text-red-900">Reject</button> --}}
                        <button class="bg-green-600 hover:bg-green-900 text-white rounded-md p-2">Approve</button>
                        <button class="bg-red-600 hover:bg-red-900 text-white rounded-md p-2">Reject</button>
                        <button class="bg-blue-600 hover:bg-blue-900 text-white rounded-md p-2">Reviewer feedback</button>

                </td>
                <td>
                    {{-- <button onclick="assignReviewer({{ $editor->id }})" class="btn btn-success btn-sm">Assign Reviewer</button> --}}
                </td>
            </tr>
            {{-- @foreach ($editors as $editor)
            <tr data-id="{{ $editor->id }}">
                <td>{{ $editor->id }}</td>
                <td>{{ $editor->name }}</td>
                <td>{{ $editor->status }}</td>
                <td>
                    <select name="reviewer" class="form-select">
                        @foreach ($reviewers as $reviewer)
                            <option value="{{ $reviewer->id }}">{{ $reviewer->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <button onclick="assignReviewer({{ $editor->id }})" class="btn btn-success btn-sm">Assign Reviewer</button>
                </td>
            </tr>
            @endforeach --}}
        </tbody>
    </table>
</div>
{{-- <script>
    function assignReviewer(editorId) {
        // const selectElement = document.querySelector(`tr[data-id="${editorId}"] select[name="reviewer"]`);
        const reviewerId = selectElement.value;
        // const url = `{{ route('admin.editors.assignReviewer', ['editor' => ':editorId', 'reviewer' => ':reviewerId']) }}`.replace(':editorId', editorId).replace(':reviewerId', reviewerId);

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (response.ok) {
                alert('Reviewer assigned successfully');
            } else {
                alert('Failed to assign reviewer');
            }
        });
    }
</script> --}}

{{-- <div class="border rounded-lg shadow-lg p-6 bg-white h-screen">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Submissions Management</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 divide-y divide-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        Title
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-12 py-3 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider ">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($submissions ?? [] as $submission)
                    <tr class="hover:bg-gray-50 transition">
                        <!-- Title -->
                        <td class="px-6 py-4 text-gray-900 text-sm">
                            {{ $submission->title }}
                        </td>
                        <!-- Status -->
                        <td class="px-6 py-4">
                            <span
                                class="px-3 py-1 text-xs font-medium rounded-full {{ $submission->status_badge ?? 'bg-gray-200 text-gray-800' }}">
                                {{ ucfirst($submission->status) }}
                            </span>
                        </td>
                        <!-- Actions -->
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex space-x-3">
                                @if ($submission->status === 'pending')
                                    <button
                                        onclick="showApproveModal({{ $submission->id }}, '{{ route('admin.submissions.approve', ':id') }}')"
                                        class="text-green-600 hover:text-green-900">Approve</button>
                                    <button
                                        onclick="showRejectModal({{ $submission->id }}, '{{ route('admin.submissions.reject', ':id') }}')"
                                        class="text-red-600 hover:text-red-900">Reject</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500 text-sm">
                            No submissions found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="mt-4">{{ $submissions->links() }}</div>
</div>

<div id="approve-modal" class="hidden fixed z-50 inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center h-4/5">
    <div class="bg-white rounded-lg p-6 w-96 h-full overflow-auto">
        <h3 class="text-lg font-semibold mb-4">Approve Submission</h3>
        <form id="approve-form" method="POST">
            @csrf
            <input type="hidden" name="submission_id" id="approve-submission-id">
            <div class="mb-4">
                <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                <input type="text" name="year" id="year"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="volume" class="block text-sm font-medium text-gray-700">Volume</label>
                <input type="text" name="volume" id="volume"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="issue" class="block text-sm font-medium text-gray-700">Issue</label>
                <input type="text" name="issue" id="issue"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="text-gray-700" onclick="closeModal('approve-modal')">Cancel</button>
                <button type="submit" class="text-white bg-green-600 px-4 py-2 rounded-md">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="hidden fixed z-50 inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center h-4/5">
    <div class="bg-white rounded-lg p-6 w-96 h-full overflow-auto">
        <h3 class="text-lg font-semibold mb-4">Reject Submission</h3>
        <form id="reject-form" method="POST">
            @csrf
            <div class="mb-4">
                <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Rejection</label>
                <textarea name="reason" id="reason" rows="4"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="text-gray-700" onclick="closeModal('reject-modal')">Cancel</button>
                <button type="submit" class="text-white bg-red-600 px-4 py-2 rounded-md">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showApproveModal(submissionId, approveRoute) {
        const approveModal = document.getElementById('approve-modal');
        const approveForm = document.getElementById('approve-form');
        approveForm.action = approveRoute.replace(':id', submissionId); // Replace placeholder with ID
        approveModal.classList.remove('hidden');
    }

    function showRejectModal(submissionId, rejectRoute) {
        const rejectModal = document.getElementById('reject-modal');
        const rejectForm = document.getElementById('reject-form');
        rejectForm.action = rejectRoute.replace(':id', submissionId); // Replace placeholder with ID
        rejectModal.classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script> --}}
