@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-lg md:text-lg lg:text-2xl font-bold">Announcements</h1>
        </div>

        <!-- Main Content -->
        <div class="p-6">
            <!-- Featured Announcement -->
            <div class="mb-8 bg-white rounded-lg border p-6">
                <h2 class="text-base md:text-base lg:text-xl font-bold mb-2">Call for Papers</h2>
                <div class="text-gray-600 text-xs md:text-sm lg:text-base mb-2">{{$announcements->published_at}}</div>
                <div class="prose max-w-none">
                    <h3 class="text-sm md:text-base lg:text-xl font-semibold mb-2">Cambodian Journal of Educational Research</h3>
                    <div class="flex text-xs md:text-sm lg:text-base items-center space-x-4">
                        <p>{{$announcements->content}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
