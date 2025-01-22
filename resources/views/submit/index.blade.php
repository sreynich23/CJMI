@extends('layouts.app')

@section('content')
<div class="p-6 bg-white">
    <!-- Submission Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Submit Manuscript</h1>

        <!-- Submission Checklist -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Submission Checklist</h2>
            <ul class="list-disc ml-6 space-y-3 text-gray-700">
                @forelse ($checklistItems as $item)
                    <li>{{ $item->content }}</li>
                @empty
                    <li>No checklist items available.</li>
                @endforelse
            </ul>
        </div>

        <!-- Submit Manuscript Form -->
        <div class="mt-8">
            <form action="{{ route('submit.manuscript') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-700 focus:ring-green-700">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Abstract</label>
                    <textarea name="abstract" rows="4" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-700 focus:ring-green-700"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Manuscript File</label>
                    <input type="file" name="manuscript" required accept=".doc,.docx,.pdf"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    <p class="mt-1 text-sm text-gray-500">Accepted formats: PDF, DOC, DOCX (Max. 10MB)</p>
                </div>

                <div>
                    <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded hover:bg-green-800">
                        Submit Manuscript
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
