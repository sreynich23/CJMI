@extends('layouts.app')

@section('content')
    <div class="flex flex-col max-w-screen-xl text-white mx-auto md:flex-row md:px-2 lg:px-4 py-4">
        <div class="bg-gray-100 px-3 lg:px-2 rounded-lg shadow-sm mb-6 h-full">
            <div class="bg-white">
                <div class="lg:py-2 bg-slate-200 h-full">
                    <form action="{{ route('search') }}" method="GET" class="flex items-center px-2">
                        <input type="text" name="query"
                            class="text-black flex-1 px-3 py-2 text-sm border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Search..." value="{{ request()->query('query') }}">
                        <button type="submit"
                            class="p-2 bg-blue-500 text-white hover:bg-blue-600 transition-colors justify-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M8.5 2a6.5 6.5 0 014.71 11.11l4.09 4.09a1 1 0 01-1.42 1.42l-4.09-4.09A6.5 6.5 0 118.5 2zm0 2a4.5 4.5 0 100 9 4.5 4.5 0 000-9z" />
                            </svg>
                        </button>
                    </form>
                    <img src="{{ asset('storage/bg_images/cover.png') }}" alt="Cover Image" class="h-full object-cover">
                </div>
            </div>
            <div class="mb-12">
                <h2 class="text-sm lg:text-2xl font-bold text-gray-800 mb-4">Search Results</h2>
                <div id="highlight-section" class="bg-white rounded-lg shadow-md p-4 h-5/6 overflow-hidden">
                    <div id="carousel" class="flex transition-transform duration-500">
                        @forelse ($articles as $index => $article)
                            @if (stripos($article->title, request()->query('query')) !== false)
                                <div class="w-full flex-shrink-0 p-4"
                                    onclick="window.location.href='{{ route('articles.show', $article->id) }}'">
                                    <h3 class="text-lg font-semibold text-blue-600">
                                        <a class="hover:text-blue-800" href="{{ route('articles.show', $article->id) }}">
                                            {{ $article->title }}
                                            <p class="text-sm text-gray-500 mt-2">
                                                {{ $article->updated_at->format('M d, Y') }}
                                            </p>
                                            <p class="text-gray-500 mt-2 text-base">
                                                {{ Str::limit($article->abstract, 250) }}
                                            </p>
                                            <a class="text-blue-600 hover:text-blue-800 mt-4 block">Read More →</a>
                                        </a>
                                    </h3>
                                </div>
                            @endif
                        @empty
                            <p class="text-gray-500">No articles found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
