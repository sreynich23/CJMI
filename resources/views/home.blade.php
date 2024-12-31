<!-- filepath: /c:/Users/TK Custom/OneDrive/Desktop/CJMI/resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 flex bg-white">
        <!-- Main Content Grid -->
        <div class="bg-gray-100 rounded-lg shadow-sm p-6 mb-6 w-3/4">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Latest Articles</h2>

            <!-- Display Articles -->
            @foreach ($articles as $article)
                @if ($article->cover_image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $article->cover_image) }}" alt="Cover Image"
                            class="w-full h-auto rounded-lg">
                    </div>
                @endif
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="mb-2 text-sm text-gray-500">
                        {{ $article->updated_at->format('M d, Y') }}
                    </div>
                    <h3 class="text-2xl font-semibold mb-3">
                        <a href="{{ route('articles.show', $article->id) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $article->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4">
                        {{ Str::limit($article->abstract, 200) }}
                    </p>
                    <a href="{{ route('articles.show', $article->id) }}" class="text-blue-600 hover:text-blue-800 border p-2 rounded-lg">Read More →</a>
                </div>
            @endforeach

        </div>

        <!-- Sidebar Section -->
        <div class="w-1/4 py-10 px-4">
            <!-- Search Form Section -->
            <div class="w-full mb-6 flex justify-center">
                <form action="{{ route('home') }}" method="GET" class="w-full max-w-lg">
                    <input type="text" name="query"
                        class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Search Articles..." value="{{ request()->query('query') }}">
                    <button type="submit" class="w-full mt-2 bg-green-500 text-white py-2 rounded-md hover:bg-green-700">
                        Search
                    </button>
                </form>
            </div>
            <!-- Display uploaded cover image if available -->
            <div class="sticky top-4">
                @if ($image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Cover Image">
                @else
                    <p>No image available</p>
                @endif
            </div>
        </div>
    </div>
@endsection
