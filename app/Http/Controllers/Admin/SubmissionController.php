<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\FileSubmission;
use App\Models\JournalInformation;
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
        $recentItems = JournalIssue::orderBy('publication_date', 'desc')->paginate(10);
        return view('admin.dashboard', compact('submissions', 'recentItems'));
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
    public function approve(Request $request, $id)
    {
        $submission = Submit::findOrFail($id); // Fetch the submission by ID
        $submission->update(['status' => 'approved']); // Update the status to approved

        // Validate the input
        $request->validate([
            'year' => 'required|numeric|min:1900|max:' . date('Y'),
            'volume' => 'required|string|max:255',
            'issue' => 'required|string|max:255',
        ]);

        // Insert data into the journal_issues table
        $journalIssue = JournalIssue::create([
            'title' => $submission->title,
            'description' => $submission->description ?? 'N/A',
            'volume' => $request->volume,
            'issue' => $request->issue,
            'publication_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Article::create([
            'journal_issue_id' => $journalIssue->id,
            'title' => $submission->title,
            'subtitle' => $submission->subtitle, // Add subtitle
            'abstract' => $submission->abstract,
            'keywords' => $submission->keywords, // Add keywords
            'pdf_url' => $submission->file_path,
            'user_id' => $submission->user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Redirect with success message
        return redirect()->back()->with('success', 'Submission approved and added to Journal Issues successfully!');
    }

    public function reject(Request $request, $id)
    {
        $submission = Submit::findOrFail($id); // Fetch the submission by ID
        $submission->update(['status' => 'rejected']); // Update the status to rejected

        return redirect()->back()->with('success', 'Submission rejected successfully.');
    }

    public function updateJournalInfo(Request $request)
    {
        $request->validate([
            'journal_name' => 'required|string|max:255',
            'editorial_office' => 'required|string|max:255',
            'developer' => 'required|string|max:255',
        ]);

        $journalInfo = JournalInformation::first();
        if ($journalInfo) {
            $journalInfo->update($request->only(['journal_name', 'editorial_office', 'developer']));
        } else {
            JournalInformation::create($request->only(['journal_name', 'editorial_office', 'developer']));
        }

        return redirect()->back()->with('success', 'Journal information updated successfully!');
    }
}
