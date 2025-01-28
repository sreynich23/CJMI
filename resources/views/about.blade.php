@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <aside class="flex bg-white gap-5">
        <!-- Sidebar -->
        <div class="w-1/5 rounded-md">
            <ul class="space-y-2 sticky top-24">
                @forelse ($abouts as $about)
                    <li>
                        <a href="#{{ Str::slug($about->title) }}"
                            class="block border border-green-700 rounded-md px-4 py-2 text-black hover:bg-green-600 hover:text-white">
                            {{ $about->title }}
                        </a>
                    </li>
                @empty
                    <li class="text-gray-500">No sections available</li>
                @endforelse
            </ul>
        </div>

        <!-- Main Content -->
        <div class="bg-gray-100 w-full p-5 rounded gap-5">
            <div class="bg-white rounded p-6 space-y-6">
                <div class="text-2xl font-semibold mb-6">About This Journal</div>

                <!-- Content Sections -->
                @forelse ($abouts as $about)
                    <div id="{{ Str::slug($about->title) }}" class="mb-8">
                        <h2 class="text-xl font-bold mb-4">{{ $about->title }}</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! $about->description !!}
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No content available</p>
                @endforelse
            </div>
        </div>
    </aside>
</div>
@endsection

@push('styles')
<style>
    html {
        scroll-behavior: smooth;
    }

    .prose {
        max-width: none;
    }

    .prose p {
        margin-bottom: 1rem;
    }

    .prose ul {
        list-style-type: disc;
        padding-left: 1.5rem;
    }

    .prose ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
    }
</style>
@endpush
