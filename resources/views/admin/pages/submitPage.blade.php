<div class="border rounded-lg shadow-lg p-6 bg-white">
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
                        <td class="px-6 py-4 space-x-2 text-right">
                            <form action="{{ route('admin.submissions.approve', $submission) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="text-sm text-green-600 hover:text-green-800 font-medium transition">
                                    Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.submissions.reject', $submission) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="text-sm text-red-600 hover:text-red-800 font-medium transition">
                                    Reject
                                </button>
                            </form>
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
    <div class="mt-6">
        {{ $submissions->links('pagination::tailwind') }}
    </div>
</div>
