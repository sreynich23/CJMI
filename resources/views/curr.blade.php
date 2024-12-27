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
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-2 w-full">
                <!-- Volume Navigation -->
                <button class="text-green-700 hover:text-green-900 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <div class="flex-1 flex items-center justify-center space-x-6 overflow-x-auto scrollbar-hide">
                    <span class="font-semibold text-xl text-gray-800 whitespace-nowrap">
                        Volume {{ $journalInfo->current_volume ?? '1' }}, {{ date('Y') }}
                    </span>
                    <!-- Add dynamic previous volumes if needed -->
                </div>

                <button class="text-green-700 hover:text-green-900 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <a href="#" class="text-blue-900 hover:underline whitespace-nowrap">All volumes & issues</a>
        </div>
    </div>

    <!-- Issues Navigation and Content -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <!-- Issues Navigation -->
        <div class="flex items-center justify-center space-x-4 mb-6 border-b pb-4">
            <button class="text-gray-700 hover:text-gray-900 focus:outline-none">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <nav class="flex space-x-6 text-center overflow-x-auto scrollbar-hide">
                @foreach($journalInfo->issues ?? [2, 1] as $issue)
                    <a href="#" class="text-green-700 {{ request()->get('issue') == $issue ? 'font-bold border-b-2 border-green-700' : '' }} hover:font-bold hover:border-b-2 hover:border-green-700 pb-2 px-2">
                        Issue {{ $issue }}
                    </a>
                @endforeach
            </nav>

            <button class="text-gray-700 hover:text-gray-900 focus:outline-none">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Articles List -->
        <div class="space-y-6">
            @include('wigets.articles')
        </div>
    </div>
</div>
@endsection

