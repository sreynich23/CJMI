@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <!-- Main Content Grid -->
        <!-- Articles Section -->
        <div class=" bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Latest Articles</h2>

            @foreach($articles ?? [] as $article)
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="mb-2 text-sm text-gray-500">
                    Posted on {{ $article->published_at ?? 'Recent' }}
                </div>
                <h3 class="text-xl font-semibold mb-3">
                    <a href="#" class="text-blue-600 hover:text-blue-800">
                        {{ $article->title ?? 'Article Title' }}
                    </a>
                </h3>
                <div class="text-gray-600 mb-4">
                    {{ $article->excerpt ?? 'Article excerpt...' }}
                </div>
                <a href="#" class="text-blue-600 hover:text-blue-800">Read More →</a>
            </div>
            @endforeach
        </div>
</div>
@endsection



