@extends('layouts.app')

@section('content')
<aside class="p-2 flex bg-white gap-5">
    <!-- Sidebar -->
    <div class="w-1/5 sticky top-4 h-screen overflow-y-auto">

        <ul class="space-y-2">
            {{-- Sidebar Links --}}
            @forelse ($abouts as $about)
                <li>
                    <a href="#{{ Str::slug($about->title) }}"
                        onclick="editAbout('{{ $about->id }}', '{{ $about->title }}', '{{ $about->description }}')"
                        class="block border border-green-700 rounded-md px-4 py-2 text-black hover:bg-green-600 hover:text-white">
                        {{ $about->title }}
                    </a>
                </li>
            @empty
                <li class="text-gray-500"></li>
            @endforelse
        </ul>

    </div>

    <!-- Main Content -->
    <div class="bg-gray-100 w-full p-5 rounded gap-5">
        <div class="bg-white rounded p-6 space-y-6">
            <div class="text-2xl font-semibold">About This Journal</div>
            <!-- Dynamic Content Section -->
            @if($abouts->count() > 0)
                @foreach($abouts as $about)
                    <div id="content-{{ $about->id }}" class="mb-6">
                        <h1 id="title-{{ $about->id }}" class="text-xl font-bold">{{ $about->title }}</h1>
                        <p id="description-{{ $about->id }}" class="text-gray-700">{{ $about->description }}</p>
                    </div>
                @endforeach
            @else
                <div class="text-gray-500">No information available yet.</div>
            @endif
        </div>
    </div>
</aside>
@endsection
