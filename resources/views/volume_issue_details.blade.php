@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-center mb-6">
            Volume {{ $volumeIssue->volume }} Issue {{ $volumeIssue->issue }} ({{ $volumeIssue->year }})
        </h1>
        <div class="">
             <?php
                $volumeImages = App\Models\VolumeIssueImage::where('volume_issue_id', $volumeIssue->id)->get();
                ?>
                <img src="{{ asset('storage/' . $volumeImages->first()->image_path) }}" alt="Volume Image"
                    class="w-1/2 md:w-1/4 ">
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            @forelse ($data as $item)
                <div class="border-b pb-4 mb-4">
                    <h3 class="text-xl font-semibold text-blue-900 mb-2">
                        <a href="{{ route('articles.show', $item->id) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $item->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600">
                        Published on: {{ $item->publication_date->format('M d, Y') }}
                    </p>
                    <p class="text-gray-600">
                        Abstract: {{ $item->abstract }}
                    </p>
                    <a href="{{ route('download.article', $item->id) }}" class="text-green-700 hover:text-green-900">
                        Download PDF
                    </a>
                </div>
            @empty
                <p class="text-center text-gray-500">No data available for this volume and issue.</p>
            @endforelse
        </div>
    </div>
@endsection
