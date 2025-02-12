@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <!-- Journal Title -->
        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
            <h1 class="text-3xl md:text-4xl text-blue-900 font-medium">
                {{ $journalInfo->journal_name ?? 'Cambodian Journal of Multidisciplinary Research and Innovation' }}
            </h1>

        </div>
        <div class="items-center justify-center flex">
            @if ($latestYear)
                <h2 class="text-3xl font-semibold text-gray-900 mb-4">
                    Current: {{$latestYear->volume}} Issue: {{$latestYear->issue}} ({{$latestYear->year}})
                </h2>
            @else
                <h2 class="text-3xl font-semibold text-gray-900 mb-4">
                    No data available.
                </h2>
            @endif
        </div>
        <!-- Articles List -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            @forelse($recentItems as $item)
                <div class="border-b pb-4 mb-4">
                    <!-- Article Title -->
                    <h3 class="text-xl font-semibold text-blue-900 mb-2">
                        {{ $item->title ?? 'Untitled Article' }}
                    </h3>

                    <!-- Check for Publication Date -->
                    @if (isset($item->publication_date))
                        <p class="text-gray-600 mb-2">
                            Published on: {{ \Carbon\Carbon::parse($item->publication_date)->format('M d, Y') }}
                        </p>
                    @else
                        <p class="text-gray-600 mb-2">Publication Date: Not Available</p>
                    @endif

                    <!-- Links -->
                    <div class="flex space-x-4">
                        @if (isset($item->id))
                            <a href="{{ route('articles.show', ['id' => $item->id]) }}"
                                class="text-green-700 hover:text-green-900">
                                View Issue
                            </a>
                            <a href="{{ route('files.download', $item->id) }}" class="text-green-700 hover:text-green-900">
                                Download PDF
                            </a>
                        @else
                            <span class="text-gray-500">No Actions Available</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    No recent journal issues available.
                </div>
            @endforelse
        </div>
    </div>
@endsection
