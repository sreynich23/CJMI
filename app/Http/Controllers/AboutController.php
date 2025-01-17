<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Announcement;
use App\Models\FileSubmission;
use App\Models\JournalInformation;
use App\Models\JournalIssue;
use App\Models\Navbar;
use App\Models\Submit;
use App\Models\VolumeIssueImage;
use App\Models\Editor;
use App\Models\Review;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::all();
        $image = VolumeIssueImage::latest()->first();
        $navbar = Navbar::latest()->first();
        $journalInfo = JournalInformation::first();
        $announcements = Announcement::first();
        $submissions = Submit::with(['article', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(100);
        $recentItems = JournalIssue::with('articles')->orderBy('publication_date', 'desc')->paginate(100);
        $latestYear = JournalIssue::query()->max('year');
        return view('admin.dashboard', compact('abouts', 'submissions', 'recentItems', 'image', 'latestYear','navbar', 'journalInfo', 'announcements'));
    }

    public function assignReviewer(Request $request, Editor $editor, Review $reviewer)
    {
        // Validate that the editor and reviewer exist
        if (!$editor || !$reviewer) {
            return response()->json(['error' => 'Invalid editor or reviewer'], 400);
        }

        // Assign the reviewer to the editor
        $editor->reviewer_id = $reviewer->id;
        $editor->status = 'Assigned'; // Optionally update status
        $editor->save();

        return response()->json(['message' => 'Reviewer assigned successfully'], 200);
    }

    public function indexuser()
    {
        $abouts = About::orderBy('created_at', 'desc')->get();
        $latestYear = JournalIssue::query()->max('year');
        $navbar = Navbar::latest()->first();
        return view('about', compact('abouts', 'latestYear','navbar'));
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
        $submission = Submit::findOrFail($id); // Fetch the submission by ID
        $submission->update(['status' => 'approved']); // Update the status to approved
        // Insert details into the journal_issues table
        \App\Models\JournalIssue::create([
            'publication_date' => now(),
            'title' => $submission->title ?? 'Untitled',
            'description' => $submission->description ?? 'No description provided',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Submission approved successfully.');
    }

    public function reject($id)
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
            'content' => 'required|string|max:1000',
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
}
