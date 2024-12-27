<div class="border rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">All Submissions</h2>

    @if($submissions->isEmpty())
        <p class="text-gray-500">No submissions found.</p>
    @else
        <div class="overflow-x-auto">
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
                    @foreach($submissions as $submission)
                        <tr>
                            <td class="px-6 py-4">
                                {{ $submission->article->title ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $submission->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm">{{ $submission->original_filename }}</span>
                                <span class="text-xs text-gray-500 block">{{ $submission->file_type }} - {{ number_format($submission->file_size / 1024, 2) }} KB</span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $submission->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $submission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                       ($submission->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <div class="flex space-x-3">
                                    <a href="{{ $submission->getFileUrl() }}"
                                       class="text-blue-600 hover:text-blue-900"
                                       target="_blank">
                                        Download
                                    </a>
                                    @if($submission->status === 'pending')
                                        <form action="{{ route('admin.submissions.approve', $submission->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.submissions.reject', $submission->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $submissions->links() }}
        </div>
    @endif
</div>
