<div class="border rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Submissions Management</h2>
    <div class="space-y-4">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($submissions ?? [] as $submission)
                        <tr>
                            <td class="px-6 py-4">{{ $submission->title }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $submission->status_badge }}">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.submissions.show', $submission) }}"
                                    class="text-blue-600 hover:text-blue-900">Review</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
