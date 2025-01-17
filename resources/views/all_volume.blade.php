@extends('layouts.app')

@section('content')
    <div class="bg-white shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300 ease-in-out mx-16 p-6 my-6">
        <h1 class="text-3xl font-bold text-center mb-6">All Volumes and Issues</h1>
        <ul>
            @php
                $seen = [];
            @endphp
            @if (is_array($volumes) || is_object($volumes))
                @foreach ($volumes as $volume => $issues)
                    @foreach ($issues as $issue)
                        @php
                            $key = "Volume {$issue->volume} Issue {$issue->issue} ({$issue->year})";
                        @endphp
                        @if (!in_array($key, $seen))
                        <div class=" p-2 transition-shadow duration-300 ease-in-out">
                            <div class="flex flex-col justify-between h-full">
                            <li>
                                <a href="{{ route('volume.issue.details', ['volume' => $issue->volume, 'issue' => $issue->issue, 'year' => $issue->year]) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $key }}
                                </a>
                                @if (is_array($issue->volumeIssueImages) || is_object($issue->volumeIssueImages))
                                    @foreach ($issue->volumeIssueImages as $image)
                                        <div class="mt-2">
                                            <img src="{{ asset($image->image_path) }}" alt="{{ $key }}" class="w-full h-auto">
                                        </div>
                                    @endforeach
                                @endif
                            </li></div></div>
                            @php
                                $seen[] = $key;
                            @endphp
                        @endif
                    @endforeach
                @endforeach
            @endif
        </ul>
    </div>
@endsection
