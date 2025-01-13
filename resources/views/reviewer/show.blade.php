@extends('layouts.app')

@section('content')
    <div class="border rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Reviewer Feedback</h2>

        @if ($feedback->isEmpty())
            <p class="text-gray-500">No feedback found for this reviewer.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submission ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comments</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recommendation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($feedback as $item)
                            <tr>
                                <td class="px-6 py-4">{{ $item->submission_id }}</td>
                                <td class="px-6 py-4">{{ $item->comments }}</td>
                                <td class="px-6 py-4">{{ $item->recommendation }}</td>
                                <td class="px-6 py-4">{{ $item->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
