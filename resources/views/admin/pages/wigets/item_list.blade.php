<div class="border rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">Recent Items</h2>
    <div class="space-y-4">
        @forelse($recentItems ?? [] as $item)
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded">
                <div>
                    <p class="font-medium">{{ $item->title }}</p>
                    <p class="text-sm text-gray-500">{{ $item->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex space-x-2">
                    <button class="text-blue-600 hover:text-blue-900">Edit</button>
                    <button class="text-red-600 hover:text-red-900">Delete</button>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No items found</p>
        @endforelse
    </div>
</div>
