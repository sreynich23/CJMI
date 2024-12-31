@forelse($articles as $article)
<article class="border-b pb-4 last:border-b-0">
    <h3 class="text-xl font-semibold text-blue-900 mb-2">
        {{ $articles->title }}
    </h3>

    <p class="text-gray-600 mb-4">
        {{ Str::limit($articles->abstract, 200) }}
    </p>

    <div class="flex items-center gap-4">
        <a href="{{ route('files.show', $articles->id) }}"
           class="text-green-700 hover:text-green-900 font-medium">
            Read full article
        </a>
        <span class="text-gray-400">|</span>
        <a href="{{ route('files.download', $articles->id) }}"
           class="text-green-700 hover:text-green-900">
            Download PDF
        </a>
    </div>
</article>
@empty
<div class="text-center py-8 text-gray-500">
    No articles available in this issue.
</div>
@endforelse

{{-- @if($articles->hasPages())
    <div class="mt-6">
        {{ $articles->links() }}
    </div>
@endif --}}
