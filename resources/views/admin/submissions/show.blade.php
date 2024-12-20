@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Review Submission</h1>
                <a href="{{ route('admin.submissions.index') }}"
                    class="text-blue-600 hover:text-blue-800">← Back to List</a>
            </div>

            <!-- Submission Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold">Title</h3>
                        <p>{{ $submission->article->title }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Abstract</h3>
                        <p class="text-gray-700">{{ $submission->article->abstract }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Keywords</h3>
                        <p>{{ $submission->article->keywords }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold">File Details</h3>
                        <p>Original Name: {{ $submission->original_filename }}</p>
                        <p>Size: {{ number_format($submission->file_size / 1024 / 1024, 2) }} MB</p>
                        <p>Type: {{ $submission->file_type }}</p>
                        <a href="{{ $submission->getFileUrl() }}"
                            target="_blank"
                            class="inline-block mt-2 text-blue-600 hover:text-blue-800">
                            Download Manuscript
                        </a>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold">Status</h3>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $submission->status_badge }}">
                            {{ ucfirst($submission->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <form action="{{ route('admin.submissions.update', $submission) }}" method="POST" class="mt-6">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Review Comments</label>
                        <textarea name="review_comments" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >{{ old('review_comments', $submission->review_comments) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Decision</label>
                        <select name="status" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="pending" {{ $submission->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="under_review" {{ $submission->status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="approved" {{ $submission->status === 'approved' ? 'selected' : '' }}>Approve</option>
                            <option value="rejected" {{ $submission->status === 'rejected' ? 'selected' : '' }}>Reject</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Save Decision
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
