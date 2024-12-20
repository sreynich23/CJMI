@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold">Announcements</h1>
        </div>

        <!-- Main Content -->
        <div class="p-6">
            <!-- Featured Announcement -->
            <div class="mb-8 bg-white rounded-lg border p-6">
                <h2 class="text-xl font-bold mb-2">Call for Papers</h2>
                <div class="text-gray-600 mb-2">16-04-2024</div>
                <div class="prose max-w-none">
                    <h3 class="text-lg font-semibold mb-2">Cambodian Journal of Educational Research</h3>
                    <p class="mb-4">Volume 4, Number 1 & Number 2</p>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-blue-600 hover:text-blue-800">Read More</a>
                        <span class="text-gray-400">|</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800">Read more about Call for Papers</a>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection
