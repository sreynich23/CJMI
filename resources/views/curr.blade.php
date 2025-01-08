@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <!-- Journal Title -->
        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
            <h1 class="text-3xl md:text-4xl text-blue-900 font-medium">
                {{ $journalInfo->journal_name ?? 'Cambodian Journal of Multidisciplinary Research and Innovation' }}
            </h1>
        </div>

        <!-- Volume Navigation -->
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <div class="flex items-center space-x-2 w-full">
                <!-- Previous Volume Button -->
                <a href="{{ $previousVolume ? route('curr', ['volume' => $previousVolume, 'year' => request()->get('year', date('Y'))]) : '#' }}"
                    class="text-green-700 hover:text-green-900 focus:outline-none {{ $previousVolume ? '' : 'opacity-50 cursor-not-allowed' }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>

                <!-- Volume Info -->
                <div class="flex-1 flex items-center justify-center space-x-6 overflow-x-auto scrollbar-hide">
                    <span class="font-semibold text-xl text-gray-800 whitespace-nowrap">
                        Volume {{ request()->get('volume', $journalInfo->volume ?? '1') }},
                        {{ request()->get('year', date('Y')) }}
                    </span>
                </div>

                <!-- Next Volume Button -->
                <a href="{{ $nextVolume ? route('curr', ['volume' => $nextVolume, 'year' => request()->get('year', date('Y'))]) : '#' }}"
                    class="text-green-700 hover:text-green-900 focus:outline-none {{ $nextVolume ? '' : 'opacity-50 cursor-not-allowed' }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Issues Navigation and Content -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-center space-x-4 mb-6 border-b pb-4">
                <!-- Previous Issue Button -->
                {{-- <a href="{{ route('curr', ['issue' => $previousIssue, 'volume' => request()->get('volume'), 'year' => request()->get('year')]) }}"
                    class="text-gray-700 hover:text-gray-900 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a> --}}

                <!-- Issue Navigation -->
                <nav class="flex space-x-6 text-center overflow-x-auto scrollbar-hide">
                    @foreach ($journalInfo->issues ?? [2, 1] as $issue)
                        <a href="{{ route('curr', ['issue' => $issue, 'volume' => request()->get('volume'), 'year' => request()->get('year')]) }}"
                            class="text-green-700 {{ request()->get('issue') == $issue ? 'font-bold border-b-2 border-green-700' : '' }} hover:font-bold hover:border-b-2 hover:border-green-700 pb-2 px-2">
                            Issue {{ $issue }}
                        </a>
                    @endforeach
                </nav>

                <!-- Next Issue Button -->
                {{-- <a href="{{ route('curr', ['issue' => $nextIssue, 'volume' => request()->get('volume'), 'year' => request()->get('year')]) }}"
                    class="text-gray-700 hover:text-gray-900 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a> --}}
            </div>

            <!-- Articles List -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                @forelse($recentItems as $item)
                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-xl font-semibold text-blue-900 mb-2">
                            {{ $item->title }}
                        </h3>

                        <!-- Check for Volume and Issue -->
                        @if (isset($item->volume) && isset($item->issue))
                            <p class="text-gray-600 mb-2">
                                Volume: {{ $item->volume }}, Issue: {{ $item->issue }}
                            </p>
                        @endif

                        <!-- Check for Publication Date -->
                        @if (isset($item->publication_date))
                            <p class="text-gray-600 mb-2">
                                Published on: {{ $item->publication_date->format('M d, Y') }}
                            </p>
                        @endif

                        <!-- Links -->
                        @if (isset($item->id))
                            <a href="{{ route('current-issue', ['issue' => $item->id]) }}"
                                class="text-green-700 hover:text-green-900">
                                View Issue
                            </a>
                            <a href="{{ route('files.download', $item->id) }}" class="text-green-700 hover:text-green-900">
                                Download PDF
                            </a>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        No recent journal issues available.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
