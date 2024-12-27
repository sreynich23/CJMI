<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileSubmission;
use App\Models\JournalIssue;
use App\Models\Submit;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = FileSubmission::with(['article'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        // dd($submissions);
        return view('admin.dashboard', compact('submissions'));
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
    public function approve(Request $request,$id)
    {
        // $submission = Submit::findOrFail($id); // Fetch the submission by ID
        // $submission->update(['status' => 'approved']); // Update the status to approved

        // return redirect()->back()->with('success', 'Submission approved successfully.');

        // Validate the input
        $request->validate([
            'year' => 'required|numeric|min:1900|max:' . date('Y'),
            'volume' => 'required|string|max:255',
            'issue' => 'required|string|max:255',
        ]);

        // Find the submission
        $submission = Submit::findOrFail($id);

        // Update submission status to approved
        $submission->update([
            'status' => 'approved',
        ]);

        // Insert data into the journal_issues table
        JournalIssue::create([
            'title' => $submission->title,
            'description' => $submission->description ?? 'N/A',
            'year' => $request->year,
            'volume' => $request->volume,
            'issue' => $request->issue,
            'publication_date' => now(), // You can customize this as needed
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Submission approved and added to Journal Issues successfully!');
    }

    public function reject($id)
    {
        $submission = Submit::findOrFail($id); // Fetch the submission by ID
        $submission->update(['status' => 'rejected']); // Update the status to rejected

        return redirect()->back()->with('success', 'Submission rejected successfully.');
    }
}
