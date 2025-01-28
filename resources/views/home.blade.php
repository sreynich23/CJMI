@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 flex bg-white py-3">
        <!-- Main Content Grid -->
        <div class="bg-gray-100 rounded-lg shadow-sm p-6 mb-6 w-3/4">
            <!-- Latest Articles Highlight Section -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Latest Articles</h2>
                <div id="highlight-section" class="relative bg-white rounded-lg shadow-md p-4 h-5/6 overflow-hidden">
                    <!-- Carousel Container -->
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

        </div>

        <!-- Sidebar Section -->
        <div class="w-1/4 py-10 px-4">
            <!-- Display uploaded cover image if available -->
            <div class="sticky top-28">
                @if ($image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Cover Image">
                @else
                    <p>No image available</p>
                @endif
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm">
        @foreach ($articles as $index => $article)
        <div class="w-full flex-shrink-0 p-4 rounded-lg shadow-lg" onclick="window.location.href='{{ route('articles.show', $article->id) }}'">
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
                        {{ $article->journalIssue->description}}
                    </p>
                    <a class="text-blue-600 hover:text-blue-800 mt-4 block">Read More →</a>
                </a>
            </h3>
        </div>
        @endforeach
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
