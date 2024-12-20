@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 flex space-x-6">
    <div class="flex-1 bg-gray-100 p-4 rounded-lg">
        @include('wigets/listBook')
        @include('wigets/listBook')
        @include('wigets/listBook')
        @include('wigets/listBook')
        @include('wigets/listBook')
    </div>
</div>

<div class="text-blue-600 container mx-auto text-center">
    <a href="">All volumes & issues</a>
</div>
@endsection



