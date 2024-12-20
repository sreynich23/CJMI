@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach($abouts as $about)
                <div class="card mb-4">
                    <div class="card-header">{{ $about->title }}</div>
                    <div class="card-body">
                        {!! $about->description !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
