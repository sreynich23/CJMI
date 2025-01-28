<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - CJMRI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-10 w-10/12">
        <!-- Articles Section -->
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="/admin" class="inline-flex items-center py-2 px-6 transition-all duration-200 ease-in-out">
                    <!-- Back Arrow Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back
                </a>
            </div>
            <h1 class="text-4xl font-bold text-center text-gray-900 mb-8">
                Volume {{ $volumeIssue->volume }} Issue {{ $volumeIssue->issue }} ({{ $volumeIssue->year }})
            </h1>
            <!-- Image Section -->
            <div class="mb-8">
                <img src="{{ asset('storage/' . $volumeImages->first()->image_path) }}" alt="Volume Image"
                    class="w-1/2 md:w-1/4 ">
            </div>
            @forelse ($data as $item)
                <div class="border-b pb-6 mb-6 hover:bg-gray-50 transition-all duration-300 ease-in-out">
                    <h3 class="text-2xl font-semibold text-blue-900 mb-3">
                        <a href="{{ route('articles.show', $item->id) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $item->title }}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-600">
                        Published on: {{ $item->publication_date->format('M d, Y') }}
                    </p>
                    <p class="text-gray-700 mt-2 mb-4">
                        Abstract: {{ Str::limit($item->abstract, 150) }}
                    </p>
                    <a href="{{ route('files.download', $item->id) }}"
                        class="inline-block text-white bg-green-600 hover:bg-green-700 py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 ease-in-out">
                        Download PDF
                    </a>
                </div>
            @empty
                <p class="text-center text-gray-500">No data available for this volume and issue.</p>
            @endforelse
        </div>
    </div>
</body>

</html>
