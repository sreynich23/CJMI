<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\FileSubmission;
use App\Models\JournalIssue;
use App\Models\Submit;
use App\Models\VolumeIssueImage;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::all();
        $image = VolumeIssueImage::latest()->first();
        $submissions = Submit::with(['article', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            $recentItems = JournalIssue::with('articles')->orderBy('publication_date', 'desc')->paginate(10);
        $latestYear = JournalIssue::query()->max('year');
        return view('admin.dashboard', compact('abouts', 'submissions','recentItems','image','latestYear'));
    }


    public function indexuser()
    {
        $abouts = About::orderBy('created_at', 'desc')->get();
        $latestYear = JournalIssue::query()->max('year');
        return view('about', compact('abouts','latestYear'));
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
}
