@extends('layouts.app')

@section('content')
<aside class="flex bg-white gap-5 py-6">
    <!-- Sidebar -->
    <div class="w-1/5 rounded-md">
        <ul class="space-y-2 sticky top-24 w-full">
            @foreach ($teamMembers as $position => $members)
                <li>
                    <a href="#{{ Str::slug($position) }}"
                        class="block text-xs md:text-sm lg:text-base border border-blue-700 rounded-md px-4 py-2 text-black hover:bg-blue-600 hover:text-white">
                        @if ($position==='')

                        @endif
                        {{ $position }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div id="all-editorials" class="page w-4/5">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">📚EDITORIAL BOARD</h2>
        <div class="space-y-1">
            @foreach ($teamMembers as $position => $members)
            <div id="{{ Str::slug($position) }}">
                <p class="text-blue-600 font-bold text-lg">{{ $position }}</p>
                <div class="space-y-4">
                    @foreach ($members as $member)
                        <div class="bg-white shadow-md rounded-lg overflow-hidden w-full">
                            <div class="p-3 lg:flex lg:items-center lg:space-x-2">
                                @if ($member->path_image)
                                    <img src="{{ asset('storage/' . $member->path_image) }}" height="100"
                                        width="100">
                                @endif
                                <div class="flex space-x-5">
                                    <h5 class="text-base md:text-lg lg:text-xl font-semibold justify-self-center">{{ $member->name }}</h5>
                                    <p class="text-gray-600 text-xs md:text-xs lg:text-sm">
                                        {!! Str::of(nl2br(e($member->description)))
                                            ->replaceMatches('/(https?:\/\/[^\s]+)/', '<a href="$1" class="text-blue-500 hover:underline" target="_blank">$1</a>')  // Links
                                            ->replaceMatches('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', '<a href="mailto:$1" class="text-blue-500 hover:underline">$1</a>')  // Emails
                                        !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</aside>
@endsection
