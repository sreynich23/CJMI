@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Submissions</h1>
            <div class="flex items-center space-x-4">
                <a href="{{ route('submit.step1') }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
                    New Submission
                </a>
            </div>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route('submissions.index', ['tab' => 'my-queue']) }}"
                    class="@if (request()->get('tab', 'my-queue') === 'my-queue') border-green-700 text-green-700 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap pb-4 px-1 border-b-2 font-medium">
                    My Queue
                    @if ($myQueueCount > 0)
                        <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs">
                            {{ $myQueueCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('submissions.index', ['tab' => 'archives']) }}"
                    class="@if (request()->get('tab') === 'archives') border-green-700 text-green-700 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap pb-4 px-1 border-b-2 font-medium">
                    Archives
                </a>
            </nav>
        </div>

        <!-- Search and Filters -->
        <div class="flex justify-between mb-6">
            <div class="flex-1 max-w-lg">
                <form action="{{ route('submissions.index') }}" method="GET" class="flex">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search submissions..."
                        class="w-full rounded-l border-gray-300 shadow-sm focus:border-green-700 focus:ring-green-700">
                    <button type="submit"
                        class="px-4 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r hover:bg-gray-200">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>
            <div class="ml-4">
                <button type="button"
                    class="px-4 py-2 border border-gray-300 rounded shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                    Filters
                </button>
            </div>
        </div>

        <!-- Submissions List -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse($submissions as $submission)
                    <li>
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $submission->id }} {{ $submission->title }}
                                        </p>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <p class="truncate">{{ Str::limit($submission->abstract, 100) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <!-- Status Badge -->
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $submission->status_badge }}">
                                        {{ ucfirst($submission->status) }}
                                    </span>

                                    <!-- View Button -->
                                    @csrf
                                    @method('PUT')
                                    <a href="{{ route('submissions.show', $submission) }}"
                                        class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                        View
                                    </a>
                                    <!-- Update Button -->
                                    <a href="{{ route('submit.updateSubmit', ['submission' => $submission->id]) }}"
                                        class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                        Update
                                    </a>

                                    <!-- Actions Dropdown -->
                                    <div class="relative" x-data="{ open: false }">
                                        <!-- Trigger Button -->
                                        <button @click="open = !open" type="button"
                                            class="text-gray-400 hover:text-gray-600">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                            </svg>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div x-show="open"
                                             @click.away="open = false"
                                             x-cloak
                                             class="absolute left-3 transform -translate-x-full mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                            <div class="py-1">
                                                <a href="{{ route('submissions.show', $submission) }}"
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    View Details
                                                </a>

                                                <form action="{{ route('submissions.destroy', $submission) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this submission?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                                                        Delete Submission
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-8 text-center text-gray-500">
                        No submissions found.
                    </li>
                @endforelse
            </ul>

            <!-- Pagination -->
            @if ($submissions->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
