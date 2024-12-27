@extends('admin.dashboard')

@section('content')
<div class="container">
    <h2>Submissions Management</h2>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Article</th>
                    <th>Status</th>
                    <th>Submitted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $submission)
                <tr>
                    <td>{{ $submission->id }}</td>
                    <td>
                        {{ $submission->user->name }}
                        <span class="badge {{ $submission->user->status === 'blocked' ? 'bg-danger' : 'bg-success' }}">
                            {{ $submission->user->status }}
                        </span>
                    </td>
                    <td>{{ $submission->article->title }}</td>
                    <td>{{ $submission->status }}</td>
                    <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.submissions.show', $submission) }}" class="btn btn-sm btn-info">View</a>
                        @if($submission->status === 'pending')
                            <form action="{{ route('admin.submissions.approve', $submission) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                            </form>
                            <form action="{{ route('admin.submissions.reject', $submission) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $submissions->links() }}
</div>
@endsection
