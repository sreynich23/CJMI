@extends('layouts.app')

@section('content')
    <div class="container mx-auto lg:px-4 bg-white py-3 flex min-h-screen">
        <!-- Main Content Grid -->
        <div class="bg-gray-100 px-3 lg:px-2 rounded-lg shadow-sm mb-6 w-3/4 h-full">

            <div class="bg-white h-24 sm:h-48 lg:h-72 flex justify-between lg:space-x-2">
                <div class="bg-white w-1/5 h-full">
                    @if ($image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Cover Image">
                    @else
                        <p class="font-thin lg:font-semibold text-sm text-center" ></p>
                    @endif
                </div>
                <div class="w-4/5 border-2 lg:border-8 border-blue-950 lg:py-2">
                    <!-- Search Form Section -->
                    <form action="{{ route('home') }}" method="GET" class="flex flex-1 gap-2 items-center px-1">
                        <input type="text" name="query"
                            class="text-black w-3/4 h-3 lg:w-3/4 lg:h-8 px-2 lg:text-sm text-xs font-thin lg:font-semibold lg:rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Search..." value="{{ request()->query('query') }}">
                        <button type="submit"
                            class="lg:px-3 lg:py-1 lg:rounded-md text-xs bg-blue-500 hover:bg-blue-600 transition-colors lg:w-1/4 text-white">
                            Search
                        </button>
                    </form>
                    <div class="justify-between flex px-3">
                        {{-- <div class="space-y-2">
                            <p class="text-xs font-thin lg:font-semibold text-gray-700">Journal name:</p>
                            <p class="text-xs font-thin lg:font-semibold text-gray-700">Initials:</p>
                            <p class="text-xs font-thin lg:font-semibold text-gray-700">DOI:</p>
                            <p class="text-xs font-thin lg:font-semibold text-gray-700">Print ISSN:</p>
                            <p class="text-xs font-thin lg:font-semibold text-gray-700">Editor-in-Chief:</p>
                            <p class="text-xs font-thin lg:font-semibold text-gray-700">Publisher:</p>
                            <p class="text-xs font-thin lg:font-semibold text-gray-700">Citation analysis:</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-xs font-thin lg:font-semibold text-gray-900">Cambodian Journal of Multidisciplinary Research
                                and Innovation</p>
                            <p class="text-xs font-thin lg:font-semibold text-gray-900">CJMRI</p>
                            <p class="text-xs font-thin lg:font-semibold text-gray-900">Ministry of Education Youth and Sports</p>
                            <p class="text-xs font-thin lg:font-semibold text-gray-900">and 1 special issue (if required)</p>
                            <p class="text-xs font-thin lg:font-semibold text-gray-900">Prefix. XXXXX.xxxxxxx by Crossref</p>
                            <p class="text-xs font-thin lg:font-semibold text-gray-900">Dr. Sam Rany</p>
                            <p class="text-xs font-thin lg:font-semibold text-gray-900">Google Scholar, DoAJ</p>
                        </div>
                        <div class="py-6">
                            <img src="{{ asset('storage/images/qrcode.png') }}" alt="QR Code"
                                class="w-20 h-20 rounded-md shadow-md">
                        </div> --}}
                        <img src="{{ asset('storage/images/cover.jpg') }}" alt="QR Code"
                                class="h-4/5 sm:h-3/5 lg:h-4/5">
                    </div>
                </div>
            </div>
            <!-- Latest Articles Highlight Section -->
            <div class="mb-12">
                <h2 class="text-sm lg:text-2xl font-bold text-gray-800 mb-4">Latest Articles</h2>
                <div id="highlight-section" class="bg-white rounded-lg shadow-md p-4 h-5/6 overflow-hidden">
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
        <div class="w-1/4 flex flex-col space-y-4">
            <div class="bg-blue-950 h-10 px-3 justify-start items-center flex">
                <h1 class="text-white text-xs font-thin lg:font-semibold">Government, Ministry, and Institution Recognition</h1>
            </div>
            @if ($recognitions)
                @foreach ($recognitions as $recognition)
                    <div class="flex items-center space-x-2">
                        <img class="h-8 w-auto" src="{{ asset('storage/' . $recognition->logo) }}" alt="{{ $recognition->url }}">
                        <h1 class="text-xs text-white">{{ $recognition->name }}</h1>
                    </div>
                @endforeach
            @endif
            <div class="bg-blue-950 h-10 px-3 justify-start items-center flex">
                <h1 class="text-white text-xs font-thin lg:font-semibold">Indexing</h1>
            </div>
            @if ($indexings)
                @foreach ($indexings as $indexing)
                    <img class="h-8 w-auto" src="{{ asset('storage/' . $indexing->logo) }}" alt="{{ $indexing->url }}">
                @endforeach
            @endif
            <div class="bg-blue-950 h-10 px-3 justify-start items-center flex">
                <h1 class="text-white text-xs font-thin lg:font-semibold">International Conference</h1>
            </div>
            @if ($conferences)
                @foreach ($conferences as $conference)
                    <img class="h-8 w-auto" src="{{ asset('storage/' . $conference->logo) }}" alt="{{ $conference->url }}">
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
