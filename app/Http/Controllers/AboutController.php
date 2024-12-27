<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\FileSubmission;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::all();
        $submissions = FileSubmission::with(['article', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.dashboard', compact('abouts','submissions'));
    }

    public function indexuser()
    {
        $abouts = About::orderBy('created_at', 'desc')->get();
        return view('about', compact('abouts'));
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

    public function approve(FileSubmission $submission)
    {
        $submission->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Submission approved successfully.');
    }

    public function reject(FileSubmission $submission)
    {
        $submission->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Submission rejected successfully.');
    }
}
