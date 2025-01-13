<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReviewerFeedback;
use App\Models\Submission;
use App\Models\User;

class ReviewerFeedbackController extends Controller
{
    public function index()
    {
        $reviewers = User::where('role', 'reviewer')->get();
        $submissions = Submission::all();
        return view('admin.reviewers.index', compact('reviewers', 'submissions'));
    }

    public function assign(Request $request)
    {
        $submission = Submission::find($request->submission_id);
        $submission->reviewers()->attach($request->reviewer_id);
        return redirect()->route('admin.reviewers.index')->with('success', 'Reviewer assigned successfully.');
    }

    public function storeFeedback(Request $request)
    {
        $feedback = new ReviewerFeedback();
        $feedback->submission_id = $request->submission_id;
        $feedback->reviewer_id = $request->reviewer_id;
        $feedback->comments = $request->comments;
        $feedback->recommendation = $request->recommendation;
        $feedback->save();

        return redirect()->route('admin.reviewers.index')->with('success', 'Feedback submitted successfully.');
    }

    public function show($id)
    {
        $feedback = ReviewerFeedback::where('reviewer_id', $id)->get();
        return view('reviewer.show', compact('feedback'));
    }
}
