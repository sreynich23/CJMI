<?php

namespace App\Http\Controllers;

use App\Models\FileSubmission;
use App\Models\Navbar;
use App\Models\Reviewer;
use Illuminate\Http\Request;
use App\Models\ReviewerFeedback;
use App\Models\Reviewers;
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
        $filePath = $request->file('feedback_file')->storeAs('reviewer_feedback_files', 'submission_' . $request->submission_id . '_reviewer_' . $request->reviewer_id . '.' . $request->file('feedback_file')->getClientOriginalExtension(), 'public');
        $status = match ($request->recommendation) {
            'Accepted' => 'approved',
            'Major Revisions' => 'major_revisions',
            'Minor Revisions' => 'minor_revisions',
            'Rejected' => 'rejected',
        };
        $reviewerId = Reviewer::where('user_id', Auth::id())->value('id');
        ReviewerFeedback::create(
            [
                'submission_id' => $id,
                'reviewer_id' => $reviewerId,
                'recommendation' => $request->recommendation,
                'comments' => $request->recommendation !== 'accepted' ? $request->comments : null,
                'file_path' => $filePath,
            ]
        );

        Reviewers::where('submission_id', $id)->update(['status' => $status]);

        return redirect()->back()->with('success', 'Feedback submitted and status updated successfully.');
    }

    public function show($id)
    {
        $feedback = ReviewerFeedback::where('reviewer_id', $id)->get();
        return view('reviewer.show', compact('feedback'));
    }
}
