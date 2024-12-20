@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6">Submit an Article</h1>

            @include('submit.partials.progress-steps')

            <div class="text-center py-12">
                <div class="mb-6">
                    <svg class="mx-auto h-16 w-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5m36-3l-11 11-5-5M20 34L9 45l-5-5m36-3l-11 11-5-5"/>
                    </svg>
                </div>

                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Submission Complete!
                </h2>

                <p class="text-lg text-gray-600 mb-8">
                    Thank you for your submission. Your manuscript has been successfully submitted and is now under review.
                </p>

                <div class="bg-gray-50 p-6 rounded-lg mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Next Steps</h3>
                    <ul class="text-left text-gray-600 space-y-3">
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            You will receive a confirmation email shortly.
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Our editorial team will review your submission.
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            You can track the status of your submission in your dashboard.
                        </li>
                    </ul>
                </div>

                <div class="flex justify-center space-x-4">
                    <a href="{{ route('submissions.index') }}"
                       class="px-6 py-3 bg-green-700 text-white rounded-md hover:bg-green-800">
                        View My Submissions
                    </a>
                    <a href="{{ route('submit.step1') }}"
                       class="px-6 py-3 border border-gray-300 rounded-md hover:bg-gray-50">
                        Submit Another Article
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
