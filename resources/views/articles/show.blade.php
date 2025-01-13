@extends('layouts.app')

@section('content')
    <article class="border-b pb-4 last:border-b-0 p-8 w-full">
        <div class="bg-gray-100 rounded-lg shadow-lg p-6 mb-6">
                <p class="text-gray-600 mb-2">
                    Volume: {{ $article->volume }}, Issue: {{ $article->issue }}
                </p>
                <div class="h-120 w-60">
                    @if ($image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Cover Image">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
            <h3 class="text-4xl font-semibold text-blue-900 mb-2">
                {{ $article->title }}
            </h3>
            @if ($article->subtitle)
                <h4 class="text-2xl font-semibold text-gray-700 mb-2">
                    {{ $article->subtitle }}
                </h4>
            @endif
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('files.download', $article->id) }}"
                    class="text-green-700 hover:text-white hover:bg-green-900 border-green-700 border p-2 rounded-lg">
                    Download PDF
                </a>
            </div>
            <div class="gap-4">
                <h1 class="font-semibold text-blue-900 text-3xl mb-4">Article</h1>
                <p class="text-gray-600 mb-4">
                    {{ $article->abstract }}
                </p>
                @if ($article->keywords)
                    <h2 class="font-semibold text-blue-900 text-2xl mb-2">Keywords</h2>
                    <p class="text-gray-600 mb-4">
                        {{ $article->keywords }}
                    </p>
                @endif
                <div class="text-gray-800">
                    {!! $article->content !!}
                </div>
            </div>
        </div>
    </article>
@endsection
