<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Indexing;
use App\Models\JournalInformation;
use App\Models\Recognition;
use App\Models\VolumeIssueImage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $recognitions = Recognition::all();
        $indexings = Indexing::all();
        $conferences = Conference::all();
        $recentSubmissions = \App\Models\FileSubmission::latest()->take(5)->get();
        $image = VolumeIssueImage::latest()->first();

        return view('admin.dashboard', compact('recentSubmissions'.'image','recognitions', 'indexings', 'conferences'));
    }
    public function uploadRecognitions(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'logo' => 'required|image|max:2048',
            'name' => 'required|string|max:255',
            'url' =>  'required|string|max:255',
        ]);
        $path = $request->file('logo')->store('recognitions', 'public');

        // Insert the image path into the 'volume_issue_images' table
        Recognition::create([
            'logo' => $path,
            'name' => $request->name,
            'url'  => $request->url,
        ]);

        // Flash the image path and success message to the session
        session()->flash('logo', $path);
        session()->flash('success', 'recognitions uploaded successfully!');

        return redirect()->back();
    }
    public function uploadIndexings(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'logo' => 'required|image|max:2048',
            'name' => 'required|string|max:255',
            'url' =>  'required|string|max:255',
        ]);
        $path = $request->file('logo')->store('indexings', 'public');
        Indexing::create([
            'logo' => $path,
            'name' => $request->name,
            'url'  => $request->url,
        ]);
        session()->flash('logo', $path);
        session()->flash('success', 'indexings uploaded successfully!');

        return redirect()->back();
    }
    public function uploadConferences(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'logo' => 'required|image|max:2048',
            'name' => 'required|string|max:255',
            'url' =>  'required|string|max:255',
        ]);
        $path = $request->file('logo')->store('conferences', 'public');
        Conference::create([
            'logo' => $path,
            'name' => $request->name,
            'url'  => $request->url,
        ]);
        session()->flash('logo', $path);
        session()->flash('success', 'conferences uploaded successfully!');

        return redirect()->back();
    }
}
