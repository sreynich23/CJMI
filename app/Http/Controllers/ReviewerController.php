<?php

namespace App\Http\Controllers;

use App\Mail\ReviewerApprovedMail;
use App\Mail\ReviewerAssignedMail;
use App\Models\Navbar;
use App\Models\reviewer;
use App\Models\reviewers;
use App\Models\Submit;
use App\Models\User;
use App\Models\VolumeIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReviewerController extends Controller
{
    public function index()
    {
        $navbar = Navbar::latest()->first();
        $latestYear = VolumeIssue::all();
        $reviewers = DB::table('reviewers')
            ->join('submits', 'reviewers.submission_id', '=', 'submits.id')
            ->join('reviewer', 'reviewers.reviewer_id', '=', 'reviewer.id')
            ->select('submits.title as title', 'submits.file_path as file_path', 'reviewers.status', 'reviewers.submission_id', 'reviewer.user_id as user_id')
            ->get()
            ->groupBy('reviewer_id');

        return view('reviewer', compact('reviewers', 'navbar'));
    }
    public function requestRoleChange(Request $request)
    {
        Log::info('Request received', $request->all());

        // Validate the incoming request
        $request->validate([
            'cv' => 'required|file|mimes:pdf|max:2048',
            'expertise' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);


        try {
            // Get the authenticated user
            $user = \Illuminate\Support\Facades\Auth::user();

            // Store the CV file
            $cvPath = $request->file('cv')->store('cvs', 'public');

            // Create the Reviewer record
            Reviewer::create([
                'name' => $user->name,
                'email' => $user->email,
                'position' => $request->position,
                'country' => $user->country,
                'cv' => $cvPath,
                'expertise' => $request->expertise,
                'active' => false,
                'user_id' => $user->id,
            ]);

            User::findOrFail($user->id)->update(['role' => 'reviewer']);

            return redirect()->back()->with('success', 'Your request to become a Reviewer has been submitted.');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error assigning reviewer role: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while processing your request.');
        }
    }

    public function assign_reviewers(Request $request)
    {
        $reviewersIds = $request->input('reviewers', []);
        $submissionId = $request->input('submission_id');
        $articleId = $request->input('submission_id');

        // Retrieve the reviewers from the database
        $reviewers = Reviewer::whereIn('id', $reviewersIds)->get();

        // Get the submission (if needed)
        $submission = Submit::find($submissionId);
        $submission->update(['status' => 'reviewing']);
        // Send emails to the selected reviewers
        foreach ($reviewers as $reviewer) {
            Mail::to($reviewer->email)->send(new ReviewerAssignedMail($submission, $reviewer));
        }

        foreach ($reviewersIds as $reviewerId) {
            Reviewers::create([
                'reviewer_id' => $reviewerId,
                'submission_id' => $articleId,
                'status' => 'articles_under_review', // Default status
            ]);
        }

        return redirect()->back()->with('success', 'Reviewers assigned successfully.');
    }

    public function approveReviewer($id)
    {
        $reviewer = Reviewer::findOrFail($id);

        // Update reviewer status to approved
        $reviewer->active = true;
        $reviewer->save();

        // Send approval email
        Mail::to($reviewer->email)->send(new ReviewerApprovedMail($reviewer));

        return response()->json(['message' => 'Reviewer approved and email sent successfully.']);
    }
}
