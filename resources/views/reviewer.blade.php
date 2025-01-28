@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">All Review</h2>

    @if ($reviewers->isEmpty())
        <p class="text-gray-500">Empty.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($reviewers as $reviewer)
                        @foreach ($reviewer as $submission)
                        @if (auth()->user()->id === $submission->user_id && $submission->status === 'articles_under_review')
                                <tr>
                                    <td class="px-6 py-4">{{ $submission->title }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ asset('storage/' . $submission->file_path) }}" class="text-blue-600 hover:text-blue-900" target="_blank">Download</a>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <button
                                                onclick="showFeedbackModal({{ $submission->submission_id }}, 'Accepted')"
                                                class="text-green-600 hover:text-green-900">Accepted</button>
                                            <button
                                                onclick="showFeedbackModal({{ $submission->submission_id }}, 'Major Revisions')"
                                                class="text-gray-500 hover:text-green-900">Major Revisions</button>
                                            <button
                                                onclick="showFeedbackModal({{ $submission->submission_id }}, 'Minor Revisions')"
                                                class="text-gray-400 hover:text-green-900">Minor Revisions</button>
                                            <button
                                                onclick="showFeedbackModal({{ $submission->submission_id }}, 'Rejected')"
                                                class="text-red-600 hover:text-red-900">Rejected</button>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">All Review Done</h2>

    @if ($reviewers->isEmpty())
        <p class="text-gray-500">Empty.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                        {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th> --}}
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($reviewers as $reviewer)
                        @foreach ($reviewer as $submission)
                            @if (auth()->user()->id === $submission->user_id && $submission->status != 'articles_under_review')
                                <tr>
                                    <td class="px-6 py-4">{{ $submission->title }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ asset('storage/' . $submission->file_path) }}" class="text-blue-600 hover:text-blue-900" target="_blank">Download</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Modal Container -->
<div id="feedbackModal" class="modal-background hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="modal-container bg-white rounded-lg shadow-lg p-6">
        <h2 id="modalTitle" class="text-xl font-semibold mb-4"></h2>
        <form id="feedbackForm" method="POST" action="">
            @csrf
            <textarea
                id="feedbackTextarea"
                name="comments"
                class="border rounded w-full p-2 text-gray-700 mt-2"
                placeholder="Provide comments here..."
                required></textarea>
                <input type="file" name="feedback_file" class="form-input">
            <div class="mt-4 flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Submit
                </button>
                <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showFeedbackModal(submissionId, recommendation) {
        // Update modal title dynamically
        document.getElementById('modalTitle').textContent = `Feedback for ${recommendation}`;

        // Dynamically set the form action using route
        const route = `{{ route('reviewer.feedback', ':id') }}`.replace(':id', submissionId);
        document.getElementById('feedbackForm').action = route;

        // Show the modal
        document.getElementById('feedbackModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('feedbackModal').classList.add('hidden');
    }
</script>
@endsection
