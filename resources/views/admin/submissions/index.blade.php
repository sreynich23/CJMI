@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6">Manuscript Submissions</h1>

            <!-- Filters -->
            <div class="mb-6 flex gap-4">
                <select id="status-filter" class="rounded-md border-gray-300">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="under_review">Under Review</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <!-- Submissions Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($submissions as $submission)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $submission->article->title }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $submission->article->authors->pluck('name')->join(', ') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $submission->created_at->format('M d, Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $submission->status_badge }}">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.submissions.show', $submission) }}"
                                        class="text-blue-600 hover:text-blue-900">Review</a>
                                    <a href="{{ $submission->getFileUrl() }}"
                                        target="_blank"
                                        class="text-green-600 hover:text-green-900">Download</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $submissions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
