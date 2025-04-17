@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-lg md:text-lg lg:text-2xl font-bold">Announcements</h1>
        </div>

        <!-- Main Content -->
        <div class="flex rounded-lg border p-6">
            <!-- Featured Announcement -->
            <div class="mb-8 bg-white w-4/5">
                <h2 class="text-base md:text-base lg:text-xl font-bold mb-2">Call for Papers</h2>
                <div class="text-gray-600 text-xs md:text-sm lg:text-base mb-2">
                    {!! Str::of(nl2br(e("cjmri@nubb.edu.kh\n+855 31 222 8888")))
                        ->replaceMatches('/(https?:\/\/[^\s]+)/', '<a href="$1" class="text-blue-500 hover:underline" target="_blank">$1</a>')
                        ->replaceMatches('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', '<a href="mailto:$1" class="text-blue-500 hover:underline">$1</a>')
                    !!}
                </div>
                <div class="prose max-w-none">
                    <h3 class="text-sm md:text-base lg:text-xl font-semibold mb-2">Cambodian Journal of Multidisciplinary Research and Innovation (CJMRI)</h3>
                    <div class="flex text-xs md:text-sm lg:text-base items-center space-x-4">
                        <p>{!! Str::of(nl2br(e($announcements->content)))
                                ->replaceMatches('/(https?:\/\/[^\s]+)/', '<a href="$1" class="text-blue-500 hover:underline" target="_blank">$1</a>')  // Links
                                ->replaceMatches('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', '<a href="mailto:$1" class="text-blue-500 hover:underline">$1</a>')  // Emails
                            !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="h-full w-1/5 space-y-2">
                <a href="{{ asset('storage/manuscripts/CJMRI_Templete.docx') }}"
                                    class="text-blue-500 hover:underline" target="_blank">Download Manuscript Template</a>
                <img src="{{ asset('storage/manuscripts/announcements.jpg') }}" alt="" class="">
            </div>
        </div>
    </div>
</div>
@endsection
