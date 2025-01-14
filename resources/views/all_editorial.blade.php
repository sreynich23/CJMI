@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Editorials</h1>
        <ul>
            @foreach($editorials as $editorial)
                <li>{{ $editorial->title }}</li>
            @endforeach
        </ul>

        <h1>All Reviewers</h1>
        <ul>
            @foreach($reviewers as $reviewer)
                <li>{{ $reviewer->name }}</li>
            @endforeach
        </ul>
    </div>
@endsection
