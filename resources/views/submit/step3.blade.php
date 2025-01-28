@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('submit.step2') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Previous Step
        </a>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6">Submit an Article</h1>

            @include('submit.partials.progress-steps')

            <form action="{{ route('submit.saveStep3') }}" method="POST">
                @csrf
                <!-- Metadata Fields -->
                <div class="space-y-6">
                    <!-- Author Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Author Name <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="author_name" required
                            class="mt-1 block w-full rounded-md border-gray-300 border px-1 focus:border-blue-500 focus:ring-blue-500"
                            value="{{ old('author_name', $submission['metadata']['author_name'] ?? '') }}">
                        @error('author_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Title <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="title" required
                            class="mt-1 block w-full rounded-md border-gray-300 border px-1 focus:border-blue-500 focus:ring-blue-500"
                            value="{{ old('title', $submission['metadata']['title'] ?? '') }}">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subtitle -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                        <input type="text" name="subtitle"
                            class="mt-1 block w-full rounded-md border-gray-300 border px-1 focus:border-blue-500 focus:ring-blue-500"
                            value="{{ old('subtitle', $submission['metadata']['subtitle'] ?? '') }}">
                    </div>

                    <!-- Abstract -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Abstract <span class="text-red-600">*</span>
                        </label>
                        <textarea name="abstract" rows="10" required
                            class="mt-1 block w-full rounded-md border-gray-300 border px-1 focus:border-blue-500 focus:ring-blue-500">{{ old('abstract', $submission['metadata']['abstract'] ?? '') }}</textarea>
                        @error('abstract')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Keywords -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Keywords <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="keywords" required
                            class="mt-1 block w-full rounded-md border-gray-300 border px-1 focus:border-blue-500 focus:ring-blue-500"
                            value="{{ old('keywords', $submission['metadata']['keywords'] ?? '') }}"
                            placeholder="Enter keywords separated by commas">
                        @error('keywords')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('submit.step2') }}"
                        class="px-6 py-2 text-red-600 hover:text-red-800">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save and continue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
