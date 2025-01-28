<?php

namespace App\Http\Controllers;

use App\Models\FileSubmission;
use App\Models\Navbar;
use Illuminate\Http\Request;
use App\Models\ReviewerFeedback;
use App\Models\Submission;
use App\Models\User;
use App\Models\VolumeIssue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewerFeedbackController extends Controller
{
    public function index()
    {
        $navbar = Navbar::latest()->first();
        $latestYear = VolumeIssue::all();
        $reviewers = User::where('role', 'reviewer')->get();
        $submissions = FileSubmission::all();
        return view('admin.reviewers.index', compact('reviewers', 'submissions', 'navbar'));
    }

    public function assign(Request $request)
    {
        $submission = FileSubmission::find($request->submission_id);
        $submission->reviewers()->attach($request->reviewer_id);
        return redirect()->route('admin.reviewers.index')->with('success', 'Reviewer assigned successfully.');
    }

    public function storeFeedback(Request $request, $id)
    {
        // Validate the request inputs
        $request->validate([
            'recommendation' => 'required|in:accepted,major revisions,minor revisions,rejected',
            'comments' => 'nullable|string|max:1000',
            'feedback_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);
        $filePath = null;
        if ($request->hasFile('feedback_file')) {
            $filePath = $request->file('feedback_file')->store('reviewer_feedback_files', 'public');
        }

        // Check if feedback already exists for this submission
        $feedback = DB::table('reviewer_feedback')->where('submission_id', $id)->first();

        // Determine the status for the reviewers table based on the recommendation
        $status = match ($request->recommendation) {
            'accepted' => 'approved',
            'major revisions' => 'major_revisions',
            'minor revisions' => 'minor_revisions',
            'rejected' => 'rejected',
        };

        if (!$feedback) {
            // Insert feedback into reviewer_feedback table
            DB::table('reviewer_feedback')->insert([
                'submission_id' => $id,
                'reviewer_id' => Auth::user()->id,
                'recommendation' => $request->recommendation,
                'comments' => $request->recommendation !== 'accepted' ? $request->comments : null,
                'file_path' => $filePath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            // Update existing feedback in reviewer_feedback table
            DB::table('reviewer_feedback')->where('submission_id', $id)->update([
                'recommendation' => $request->recommendation,
                'comments' => $request->recommendation !== 'accepted' ? $request->comments : null,
                'updated_at' => now(),
            ]);
        }

        // Update the status in the reviewers table
        DB::table('reviewers')->where('submission_id', $id)->update([
            'status' => $status,
            'updated_at' => now(),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Feedback submitted and status updated successfully.');
    }



    public function show($id)
    {
        $feedback = ReviewerFeedback::where('reviewer_id', $id)->get();
        return view('reviewer.show', compact('feedback'));
    }
}
