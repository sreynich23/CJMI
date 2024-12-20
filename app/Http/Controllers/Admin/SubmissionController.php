<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileSubmission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = FileSubmission::with(['article.authors'])
            ->latest()
            ->paginate(10);

        return view('admin.submissions.index', compact('submissions'));
    }

    public function show(FileSubmission $submission)
    {
        $submission->load('article.authors');
        return view('admin.submissions.show', compact('submission'));
    }

    public function update(Request $request, FileSubmission $submission)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected',
            'review_comments' => 'nullable|string'
        ]);

        $submission->update($validated);

        // Send notification to author about status change
        // TODO: Implement notification

        return redirect()
            ->route('admin.submissions.show', $submission)
            ->with('success', 'Submission status updated successfully');
    }
}
