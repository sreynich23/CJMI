@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <!-- Back and Navigation -->
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Home
        </a>
        <a href="{{ route('submissions.index') }}"
           class="text-green-700 hover:text-green-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            View My Submissions
        </a>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6">Submit an Article</h1>

            @include('submit.partials.progress-steps')

            <form action="{{ route('submit.saveStep1') }}" method="POST">
                @csrf
                <!-- Section Policy -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4">Section Policy</h2>
                    <p class="text-gray-700 mb-4">Section default policy</p>
                </div>

                <!-- Submission Requirements -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4">Submission Requirements</h2>
                    <p class="text-gray-700 mb-4">You must read and acknowledge that you've completed the requirements below before proceeding.</p>

                    <div class="space-y-4">
                        @foreach([
                            'not_published' => 'The submission has not been previously published...',
                            'file_format' => 'The submission file is in OpenOffice, Microsoft Word, or RTF document file format.',
                            'references' => 'Where available, DOIs or URLs for the references have been provided.',
                            'formatting' => 'The text is single-spaced; uses a 12-point font...',
                            'guidelines' => 'The text adheres to the stylistic and bibliographic requirements...'
                        ] as $key => $text)
                            <div class="flex items-start">
                                <input type="checkbox"
                                    name="requirements[]"
                                    value="{{ $key }}"
                                    class="mt-1 mr-3"
                                    required
                                    @if(old("requirements.$key")) checked @endif>
                                <label class="text-gray-700">{{ $text }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Comments for Editor -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4">Comments for the Editor</h2>
                    <div class="border rounded-lg p-2">
                        <textarea name="comments"
                            rows="6"
                            class="w-full p-2 focus:outline-none border rounded">{{ old('comments') }}</textarea>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('home') }}"
                        class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-green-700 text-white rounded hover:bg-green-800">
                        Save and continue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
