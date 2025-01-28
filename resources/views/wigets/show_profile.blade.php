@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <div class="bg-gray-50 rounded-lg shadow-lg overflow-hidden">
            <div class="p-8 space-y-8">
                <!-- Profile Header -->
                <div class="text-center">
                    <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl font-bold text-white">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ Auth::user()->name }}</h1>
                    <p class="text-gray-600">{{ Auth::user()->email }}</p>
                </div>


                <!-- Personal Information Section -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">
                        Personal Information
                    </h2>
                    <p class="text-gray-800"><strong>Name:</strong> {{ Auth::user()->name }}</p>
                    <p class="text-gray-800"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                </div>

                <!-- Submissions Section -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">
                        Your Submissions
                    </h2>
                    @if (isset($submissions) && $submissions->isNotEmpty())
                        <ul class="space-y-4">
                            @foreach ($submissions as $submission)
                                <li class="bg-gray-100 p-4 rounded-lg shadow-sm">
                                    <h3 class="font-bold text-gray-800">
                                        {{ $submission->title }}
                                    </h3>
                                    <p class="text-sm text-gray-600">{{ $submission->created_at->format('M d, Y') }}</p>
                                    <p class="text-gray-700">{{ Str::limit($submission->abstract, 100) }}</p>
                                    <a href="{{ route('submissions.show', $submission->id) }}"
                                        class="text-blue-600 hover:underline">
                                        View Details
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">You haven’t made any submissions yet.</p>
                    @endif
                </div>

                <!-- Back to Home Button -->
                <div class="text-center">
                    <a href="{{ route('home') }}"
                        class="px-6 py-3 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
