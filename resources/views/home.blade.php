@extends('layouts.app')

@section('content')
    <div class="flex flex-col max-w-screen-xl text-white mx-auto md:flex-row md:px-2 lg:px-4 py-4">
        <div class="bg-gray-100 px-3 lg:px-2 rounded-lg shadow-sm mb-6 lg:w-3/4 h-full">
            <div class="bg-white">
                <div class="lg:py-2 bg-slate-200 h-full">
                    <form action="{{ route('home') }}" method="GET" class="flex items-center px-2">
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
                <h2 class="text-sm lg:text-2xl font-bold text-gray-800 mb-4">Latest Articles</h2>
                <div id="highlight-section" class="bg-white rounded-lg shadow-md p-4 h-5/6 overflow-hidden">
                    <div id="carousel" class="flex transition-transform duration-500">
                        @foreach ($articles as $index => $article)
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
                        @endforeach
                    </div>
                </div>

                <!-- Pagination Dots -->
                <div id="pagination-dots" class="flex justify-center mt-4">
                    @foreach ($articles as $index => $article)
                        <div data-index="{{ $index }}"
                            class="dot w-4 h-4 mx-1 rounded-full cursor-pointer {{ $index === 0 ? 'bg-red-500' : 'bg-gray-300' }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h1></h1>
                @foreach ($articles as $index => $article)
                    <div class="w-full flex-shrink-0 p-4 rounded-lg shadow-lg"
                        onclick="window.location.href='{{ route('articles.show', $article->id) }}'">
                        <h3 class="text-lg font-semibold text-blue-600">
                            <a class="hover:text-blue-800" href="{{ route('articles.show', $article->id) }}">
                                {{ $article->title }}
                                <p class="text-xs text-gray-500 mt-2">
                                    {{ $article->updated_at->format('M d, Y') }}
                                </p>
                                <p class="text-gray-500 mt-2 text-base">
                                    {{ Str::limit($article->abstract, 250) }}
                                </p>
                                <p class="text-gray-400 mt-2 text-sm">
                                    {{ $article->journalIssue->description }}
                                </p>
                                <a class="text-blue-600 hover:text-blue-800 mt-4 block">Read More →</a>
                            </a>
                        </h3>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="lg:w-1/4 flex flex-col space-y-4">
            <div class="bg-blue-950 h-10 px-3 justify-start items-center flex">
                <h1 class="text-white text-xs font-thin lg:font-semibold">Government, Ministry, and Institution Recognition
                </h1>
            </div>
            @if ($recognitions)
                @foreach ($recognitions as $recognition)
                    <div class="flex items-center space-x-2">
                        <a href="{{ $recognition->url }}" target="_blank">
                            <img class="lg:h-12 md:8 h-8 w-auto" src="{{ asset('storage/' . $recognition->logo) }}">
                            <h1 class="text-xs text-white">{{ $recognition->name }}</h1>
                        </a>
                    </div>
                @endforeach
            @endif
            <div class="bg-blue-950 h-10 px-3 justify-start items-center flex">
                <h1 class="text-white text-xs font-thin lg:font-semibold">Indexing</h1>
            </div>
            @if ($indexings)
                @foreach ($indexings as $indexing)
                    <a href="{{ $indexing->url }}" target="_blank">
                        <img class="lg:h-12 md:8 h-8 w-auto" src="{{ asset('storage/' . $indexing->logo) }}"
                            alt="{{ $indexing->url }}">
                    </a>
                @endforeach
            @endif
            <div class="bg-blue-950 h-10 px-3 justify-start items-center flex">
                <h1 class="text-white text-xs font-thin lg:font-semibold">International Conference</h1>
            </div>
            @if ($conferences)
                @foreach ($conferences as $conference)
                    <a href="{{ $conference->url }}" target="_blank">
                        <img class="lg:h-12 md:8 h-8 w-auto" src="{{ asset('storage/' . $conference->logo) }}"
                            alt="{{ $conference->url }}">
                    </a>
                @endforeach
            @endif
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const carousel = document.getElementById('carousel');
        const dots = document.querySelectorAll('.dot');
        const articlesCount = dots.length;
        let currentIndex = 0;
        let interval;

        // Function to update the carousel
        const updateCarousel = (index) => {
            // Update the transform to show the current article
            carousel.style.transform = `translateX(-${index * 100}%)`;

            // Update dot colors
            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.remove('bg-gray-300');
                    dot.classList.add('bg-red-500');
                } else {
                    dot.classList.remove('bg-red-500');
                    dot.classList.add('bg-gray-300');
                }
            });
        };

        // Automatic switching every 5 seconds
        const startAutoSwitch = () => {
            interval = setInterval(() => {
                currentIndex = (currentIndex + 1) % articlesCount;
                updateCarousel(currentIndex);
            }, 2000);
        };

        // Manual switching
        dots.forEach((dot) => {
            dot.addEventListener('click', (e) => {
                clearInterval(interval); // Stop automatic switching when manually interacted
                currentIndex = parseInt(e.target.dataset.index);
                updateCarousel(currentIndex);
                startAutoSwitch(); // Restart automatic switching
            });
        });

        // Initialize the carousel
        startAutoSwitch();
    });
</script>
