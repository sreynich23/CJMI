@extends('layouts.app')

@section('content')
    <div class="bg-white shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300 ease-in-out mx-16 p-6 my-6">
        <h1 class="text-3xl font-bold text-center mb-6">All Volumes and Issues</h1>

        @foreach ($formattedVolumes as $year => $volumes)
            <h3 class="text-3xl font-bold mb-4 text-center">{{ $year }}</h3>
            <div class="grid grid-cols-4 gap-4 border-b-2 pb-8">
                @foreach ($volumes as $volume)
                    <ul>
                        <li><a href="{{ route('volume.issue.details', ['id' => $volume['id_volume_issue']]) }}">
                            @if ($volume['image'])
                                <img src="{{ asset('storage/' . $volume['image']) }}" alt="Volume Image"
                                    class="w-full h-auto mt-2">
                            @else
                                <p>No image available</p>
                            @endif
                            {{ $volume['volume'] }}
                        </a>
                        </li>
                    </ul>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
