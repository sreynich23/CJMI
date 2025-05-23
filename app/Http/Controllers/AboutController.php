<?php

namespace App\Http\Controllers;

use App\Mail\accept_review;
use App\Mail\FeedbackAuthor;
use App\Mail\reject_review;
use App\Models\About;
use App\Models\Announcement;
use App\Models\Conference;
use App\Models\FileSubmission;
use App\Models\JournalInformation;
use App\Models\JournalIssue;
use App\Models\Navbar;
use App\Models\Submit;
use App\Models\VolumeIssueImage;
use App\Models\Editor;
use App\Models\EditorialTeam;
use App\Models\Indexing;
use App\Models\PoliciesGuideline;
use App\Models\Recognition;
use App\Models\Review;
use App\Models\Reviewer;
use App\Models\Reviewers;
use App\Models\User;
use App\Models\VolumeIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $recognitions = Recognition::all();
        $indexings = Indexing::all();
        $conferences = Conference::all();
        $editors = EditorialTeam::all();
        $abouts = About::all();
        $image = VolumeIssueImage::latest()->first();
        $navbar = Navbar::latest()->first();
        $journalInfo = JournalInformation::first();
        $announcements = Announcement::first();
        $reviewers = Reviewer::all();
        $reviewersEditorial = Reviewers::all();
        $submissions = Submit::with(['article', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(100);
        $submissionsUpdate = Submit::with(['article', 'user'])
            ->where('status', 'update')
            ->orderBy('created_at', 'desc')
            ->paginate(100);
        $submissionsApproved = Submit::with(['article', 'user'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->paginate(100);
        $reviewing = DB::table('reviewers')
            ->join('submits', 'reviewers.submission_id', '=', 'submits.id')
            ->join('reviewer', 'reviewers.reviewer_id', '=', 'reviewer.id')
            ->select('submits.title as title', 'submits.status as submission_status', 'submits.file_path as file_path', 'reviewers.status', 'reviewers.submission_id', 'reviewers.reviewer_id', 'reviewer.name as reviewer_name', 'reviewer.user_id as user_id')
            ->get()
            ->groupBy('submission_id');
        // Fetch all volumes with their issues, ordered by year, volume, and issue
        $volumes = VolumeIssue::query()
            ->select('id', 'volume', 'issue', 'year') // Select necessary fields
            ->orderBy('year', 'desc') // Order by year (descending)
            ->orderBy('volume', 'asc') // Then order by volume (ascending)
            ->orderBy('issue', 'asc') // Then order by issue (ascending)
            ->get();
        // Fetch images for each volume issue
        $volumeImages = VolumeIssueImage::query()
            ->whereIn('id_volume_issue', $volumes->pluck('id')) // Get images for volumes that exist
            ->get();
        $policies = PoliciesGuideline::all();
        // Group volumes by year
        $groupedVolumes = $volumes->groupBy('year');

        // Format the volumes for each year
        $formattedVolumes = [];
        foreach ($groupedVolumes as $year => $volumesByYear) {
            $formattedVolumes[$year] = $volumesByYear->map(function ($volume) use ($volumeImages) {
                // Get the image path for the current volume
                $imagePath = $volumeImages->where('id_volume_issue', $volume->id)->first()?->image_path;
                return [
                    'id_volume_issue' => $volume->id, // Include id_volume_issue
                    'volume' => 'Vol. ' . $volume->volume . ' No. ' . $volume->issue . ' (' . $volume->year . ')',
                    'image' => $imagePath,
                ];
            });
        }
        $latestYear = VolumeIssue::query()->max('year');
        return view('admin.dashboard', compact('abouts', 'submissions', 'formattedVolumes', 'image', 'latestYear', 'navbar', 'journalInfo', 'announcements', 'reviewers', 'reviewersEditorial', 'reviewing', 'submissionsUpdate', 'submissionsApproved', 'editors', 'recognitions', 'indexings', 'conferences', 'policies'));
    }

    public function indexuser()
    {
        $abouts = About::orderBy('created_at', 'desc')->get();
        $latestYear = VolumeIssue::query()->max('year');
        $navbar = Navbar::latest()->first();
        return view('about', compact('abouts', 'latestYear', 'navbar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $about = About::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'About section created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $about = About::findOrFail($id);
        $about->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'About section updated successfully');
    }

    public function destroy($id)
    {
        $about = About::findOrFail($id);
        $about->delete();

        return redirect()->back()->with('success', 'About section deleted successfully');
    }

    public function show($id)
    {
        $about = About::findOrFail($id);
        return response()->json($about);
    }

    public function approve($id)
    {
        $submission = Submit::findOrFail($id);

        $submission->update(['status' => 'approved']);

        // Send email notification to the user
        try {
            Mail::to($submission->user->email)->send(new \App\Mail\SubmissionApproved($submission));
        } catch (\Exception $e) {
            // Log error if email fails
            Log::error('Failed to send approval email: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'Submission approved successfully, and an email notification has been sent.');
    }

    public function publicSubmission($id)
    {
        $submission = Submit::findOrFail($id); // Fetch the submission by ID
        $submission->update(['status' => 'public']);
        // Insert details into the journal_issues table
        \App\Models\JournalIssue::create([
            'publication_date' => now(),
            'title' => $submission->title ?? 'Untitled',
            'description' => $submission->author_name ?? 'No description provided',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Submission approved successfully.');
    }

    public function updateJournalInfo(Request $request)
    {
        $request->validate([
            'journal_name' => 'required|string|max:255',
            'editorial_office' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'telegram' => 'required|string|max:255',
        ]);

        // Update if exists, or create a new record
        JournalInformation::updateOrCreate(
            ['id' => 1],
            $request->only(['journal_name', 'editorial_office', 'email', 'telegram'])
        );

        return redirect()->back()->with('success', 'Journal information updated successfully!');
    }
    public function updateAnnouncements(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
        ]);
        // Update if exists, or create a new record
        Announcement::updateOrCreate(
            ['id' => 1],
            $request->only(['content'])
        );

        return redirect()->back()->with('success', 'Announcement updated successfully!');
    }

    public function updateNavbar(Request $request)
    {
        $navbar = Navbar::firstOrCreate([]);

        if ($request->hasFile('logo')) {
            $navbar->logo_path = $request->file('logo')->store('images', 'public');
        }

        if ($request->hasFile('background_image')) {
            $navbar->background_color = $request->file('background_image')->store('images', 'public');
        }

        $navbar->title = $request->input('title');
        $navbar->save();

        return redirect()->back()->with('success', 'Navbar updated successfully!');
    }
    public function sendReviewFeedback($authorId, $submissionId, Request $request)
    {
        // Fetch the author and submission data
        $author = User::findOrFail($authorId);
        $submission = Submit::findOrFail($submissionId);

        // Validate the input
        $request->validate([
            'comment' => 'required|string|max:1000',
            'file' => 'nullable|mimes:pdf|max:10240',
        ]);

        $comment = $request->input('comment');

        $submission->update(['status' => 'waiting_update']);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('feedback_pdfs', 'public');
        }

        // Send the email with feedback and the optional file path
        Mail::to($author->email)->send(new FeedbackAuthor($submission, $author, $comment, $filePath));

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Feedback sent successfully.');
    }

    public function reject($authorId, $submissionId, Request $request)
    {
        // Fetch the author and submission data
        $author = User::findOrFail($authorId);
        $submission = Submit::findOrFail($submissionId);
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);
        $reason = $request->input('reason');
        $submission->update(['status' => 'rejected']);

        // Send the email with feedback
        Mail::to($author->email)->send(new reject_review($submission, $author, $reason));

        return redirect()->back()->with('success', 'Reject sent successfully.');
    }

    public function acceptReview($authorId, $submissionId)
    {
        // Fetch the author and submission data
        $author = User::findOrFail($authorId);
        $submission = Submit::findOrFail($submissionId);

        // Send the email with feedback
        Mail::to($author->email)->send(new accept_review($submission, $author));

        return redirect()->back()->with('success', 'accept sent successfully.');
    }
    public function showVolumeIssueDetails($id)
    {
        $latestYear = VolumeIssue::query()->max('year');
        $navbar = Navbar::latest()->first();

        // Use the passed ID ($id) to filter JournalIssue records
        $data = JournalIssue::query()
            ->where('id_volume_issue', $id)
            ->with('articles')
            ->get();
        $volumeIssue = VolumeIssue::query()
            ->where('id', $id)
            ->first();
        $volumeImages = VolumeIssueImage::query()
            ->where('id_volume_issue', $id)
            ->get();
        // Return the view with the filtered data
        return view('admin.volume_issue_details', compact('data', 'id', 'volumeImages', 'volumeIssue', 'latestYear', 'navbar'));
    }
    public function download($id)
    {
        $submit = Submit::findOrFail($id);

        if (!$submit->file_path) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $filePath = 'public/' . $submit->file_path;
        if (!Storage::exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::download($filePath, $submit->title . '.pdf');
    }
    public function downloadCV($id)
    {
        $reviewer = Reviewer::findOrFail($id);

        if (!$reviewer->cv) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $filePath = 'public/' . $reviewer->cv;
        if (!Storage::exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::download($filePath, $reviewer->name . '.pdf');
    }

    /**
     * Show the form for creating a new editor.
     */
    public function createEditorial()
    {
        return redirect()->back()->with('success', 'Editor created successfully.');
    }
    public function createAccEditorial(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required',
        //     'country' => 'required',
        //     'password' => [
        //         'required',
        //         'string',
        //         'min:8',
        //         'confirmed',
        //         'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
        //     ]
        // ],);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'notifications_enabled' => 1,
            'reviewer_available' => 1,
            'isAdmin' => 1,
        ]);
        return redirect()->back()->with('success', 'Account Editor created successfully.');
    }

    public function createReviewer(Request $request)
    {
        // Create the user and store the instance
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'password' => Hash::make($request->password),
            'role' => 'reviewer',
            'notifications_enabled' => 1,
            'reviewer_available' => 1,
            'isAdmin' => 1,
        ]);

        // Create the reviewer and link to the user
        Reviewer::create([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position, // fixed typo
            'country' => $request->country,
            'active' => 1,
            'user_id' => $user->id, // use created user ID
        ]);

        return redirect()->back()->with('success', 'Account Reviewer created successfully.');
    }

    /**
     * Store a newly created editor in storage.
     */
    public function storeEditorial(Request $request)
    {
        // Validate the request data, including the image file
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image file
        ]);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Get the uploaded file
            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $path = $image->storeAs('editorial_images', $imageName, 'public');

            $request->merge(['path_image' => $path]);
        }

        EditorialTeam::create($request->all());

        return redirect()->back()->with('success', 'Editor created successfully.');
    }

    public function updateEditorial(Request $request, EditorialTeam $editor)
    {
        $request->validate([
            'path_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'position' => 'required',
            'description' => 'required',
        ]);

        $data = $request->only(['name', 'position', 'description']);

        // Handle image upload if present
        if ($request->hasFile('path_image')) {
            // Delete the old image if it exists
            if ($editor->path_image) {
                Storage::disk('public')->delete($editor->path_image);
            }

            // Store the new image
            $image = $request->file('path_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('editorial_images', $imageName, 'public');

            $data['path_image'] = $path; // Add new image path to update data
        }

        // Update the editor record
        $editor->update($data);

        return redirect()->back()->with('success', 'Editor updated successfully.');
    }

    public function destroyEditorial(EditorialTeam $editor)
    {
        $editor->delete();

        return redirect()->back()->with('success', 'Editor deleted successfully.');
    }
}
