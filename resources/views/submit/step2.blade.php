@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('submit.step1') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
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

            <form action="{{ route('submit.saveStep2') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Files Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Files</h2>
                        <button type="button" onclick="document.getElementById('manuscript').click()"
                            class="text-blue-600 hover:text-blue-800">
                            Add File
                        </button>
                    </div>

                    <p class="text-gray-700 mb-4">
                        Upload any files the editorial team will need to evaluate your submission.
                        <a href="#" class="text-blue-600 hover:text-blue-800">Upload File</a>
                    </p>

                    <input type="file" id="manuscript" name="manuscript" class="hidden"
                        accept=".doc,.docx,.pdf" required>

                    <div id="file-info" class="hidden bg-gray-50 p-4 rounded-lg mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700" id="file-name"></span>
                            <button type="button" onclick="removeFile()"
                                class="text-red-600 hover:text-red-800">
                                Remove
                            </button>
                        </div>
                    </div>

                    @error('manuscript')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('submit.step1') }}"
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

<script>
document.getElementById('manuscript').addEventListener('change', function(e) {
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');

    if (this.files.length > 0) {
        fileName.textContent = this.files[0].name;
        fileInfo.classList.remove('hidden');
    } else {
        fileInfo.classList.add('hidden');
    }
});

function removeFile() {
    const input = document.getElementById('manuscript');
    const fileInfo = document.getElementById('file-info');

    input.value = '';
    fileInfo.classList.add('hidden');
}
</script>
@endsection
