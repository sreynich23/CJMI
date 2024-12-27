@extends('admin.dashboard')

@section('content')
<div class="container">
    <h2>Submission Details</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h3>User Information</h3>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $submission->user->name }}</p>
            <p><strong>Email:</strong> {{ $submission->user->email }}</p>
            <p><strong>Status:</strong> {{ $submission->user->status }}</p>

            @if($submission->user->status !== 'blocked')
                <form action="{{ route('admin.users.block', $submission->user) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Block User</button>
                </form>
            @else
                <form action="{{ route('admin.users.unblock', $submission->user) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">Unblock User</button>
                </form>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Submission Information</h3>
        </div>
        <div class="card-body">
            <p><strong>Article Title:</strong> {{ $submission->article->title }}</p>
            <p><strong>Status:</strong> {{ $submission->status }}</p>
            <p><strong>Submitted At:</strong> {{ $submission->created_at->format('Y-m-d H:i') }}</p>

            @if($submission->status === 'pending')
                <form action="{{ route('admin.submissions.approve', $submission) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">Approve</button>
                </form>
                <form action="{{ route('admin.submissions.reject', $submission) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
