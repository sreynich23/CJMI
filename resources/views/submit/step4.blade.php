@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('submit.step3') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
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

            <div class="mb-8">
                <div class="bg-white p-6">
                    <p class="text-gray-700 mb-8">
                        Your submission has been uploaded and is ready to be sent. You may go back to review and adjust any of the information you have entered before continuing. When you are ready, click "Finish Submission".
                    </p>

                    <form action="{{ route('submit.saveStep4') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="flex items-start mb-6">
                            <div class="flex items-center h-5">
                                <input id="confirm" name="confirm" type="checkbox" required
                                    class="w-4 h-4 border-gray-300 rounded text-blue-600 focus:ring-blue-500">
                            </div>
                            <label for="confirm" class="ml-3 text-sm text-gray-600">
                                I confirm that I want to complete this submission
                            </label>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('submit.step3') }}"
                                class="px-6 py-2 text-red-600 hover:text-red-800">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Finish Submission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    if (!document.getElementById('confirm').checked) {
        e.preventDefault();
        alert('Please confirm that you want to complete this submission.');
    }
});
</script>
@endsection
