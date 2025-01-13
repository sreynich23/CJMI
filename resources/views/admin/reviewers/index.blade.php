@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-3xl font-bold text-center mb-6">Manage Reviewers</h1>

        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-4">Assign Reviewer</h2>
            <form action="{{ route('admin.reviewers.assign') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="submission_id" class="block text-sm font-medium text-gray-700">Select Submission</label>
                    <select name="submission_id" id="submission_id" class="mt-1 block w-full">
                        @foreach($submissions as $submission)
                            <option value="{{ $submission->id }}">{{ $submission->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="reviewer_id" class="block text-sm font-medium text-gray-700">Select Reviewer</label>
                    <select name="reviewer_id" id="reviewer_id" class="mt-1 block w-full">
                        @foreach($reviewers as $reviewer)
                            <option value="{{ $reviewer->id }}">{{ $reviewer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Assign Reviewer</button>
            </form>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">Submit Feedback</h2>
            <form action="{{ route('admin.reviewers.feedback.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="submission_id" class="block text-sm font-medium text-gray-700">Select Submission</label>
                    <select name="submission_id" id="submission_id" class="mt-1 block w-full">
                        @foreach($submissions as $submission)
                            <option value="{{ $submission->id }}">{{ $submission->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="reviewer_id" class="block text-sm font-medium text-gray-700">Select Reviewer</label>
                    <select name="reviewer_id" id="reviewer_id" class="mt-1 block w-full">
                        @foreach($reviewers as $reviewer)
                            <option value="{{ $reviewer->id }}">{{ $reviewer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="comments" class="block text-sm font-medium text-gray-700">Comments</label>
                    <textarea name="comments" id="comments" rows="4" class="mt-1 block w-full"></textarea>
                </div>
                <div class="mb-4">
                    <label for="recommendation" class="block text-sm font-medium text-gray-700">Recommendation</label>
                    <select name="recommendation" id="recommendation" class="mt-1 block w-full">
                        <option value="approve">Approve</option>
                        <option value="reject">Reject</option>
                        <option value="revise">Revise</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Feedback</button>
            </form>
        </div>
    </div>
@endsection
