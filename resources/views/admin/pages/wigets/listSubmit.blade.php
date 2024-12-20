<div class="border rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Recent Submissions</h2>
    <div class="space-y-4">
        @forelse($recentSubmissions ?? [] as $submission)
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded">
                <div>
                    <p class="font-medium">{{ $submission->title }}</p>
                    <p class="text-sm text-gray-500">Submitted {{ $submission->created_at->diffForHumans() }}</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full {{ $submission->status_badge }}">
                    {{ ucfirst($submission->status) }}
                </span>
            </div>
        @empty
            <p class="text-gray-500">No recent submissions</p>
        @endforelse
    </div>
</div>
