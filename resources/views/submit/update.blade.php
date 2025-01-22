@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6">Update Submission</h1>
    <form action="{{ route('submit.updateSubmited', $submission->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md space-y-4">
        @csrf
        @method('POST') <!-- This method should be POST to update the submission -->

        <div class="form-group">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('title', $submission->title) }}" required>
        </div>

        <div class="form-group">
            <label for="abstract" class="block text-sm font-medium text-gray-700">Abstract</label>
            <textarea name="abstract" rows="10"  id="abstract" class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>{{ old('abstract', $submission->abstract) }}</textarea>
        </div>

        <div class="form-group">
            <label for="keywords" class="block text-sm font-medium text-gray-700">Keywords</label>
            <input type="text" name="keywords" id="keywords" class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('keywords', $submission->keywords) }}" required>
        </div>

        <div class="form-group">
            <label for="prefix" class="block text-sm font-medium text-gray-700">Prefix</label>
            <input type="text" name="prefix" id="prefix" class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('prefix', $submission->prefix) }}">
        </div>

        <div class="form-group">
            <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
            <input type="text" name="subtitle" id="subtitle" class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('subtitle', $submission->subtitle) }}">
        </div>

        <div class="form-group">
            <label for="file_path" class="block text-sm font-medium text-gray-700">Manuscript</label>
            <input type="file" name="file_path" id="file_path" class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Update Submit Button -->
        <div class="mt-4">
            <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Update Submission
            </button>
        </div>
    </form>

    <!-- Update Button (Redirect to edit form) -->
    <div class="mt-4">
        <a href="{{ route('submit.updateSubmit', ['submission' => $submission->id]) }}"
           class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
            Edit Submission
        </a>
    </div>
</div>
@endsection
