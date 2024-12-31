<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JournalInformation;
use App\Models\VolumeIssueImage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $recentSubmissions = \App\Models\FileSubmission::latest()->take(5)->get();
        $image = VolumeIssueImage::latest()->first();

        return view('admin.dashboard', compact('recentSubmissions'.'image'));
    }
    public function uploadCover(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'cover_image' => 'required|image|max:2048', // 2MB max size
        ]);

        // Store the image in the 'covers' directory
        $path = $request->file('cover_image')->store('covers', 'public');

        // Insert the image path into the 'volume_issue_images' table
        VolumeIssueImage::create([
            'image_path' => $path,
            'volume_issue_id'=>'1'
        ]);

        // Flash the image path and success message to the session
        session()->flash('cover_image', $path);
        session()->flash('success', 'Cover image uploaded successfully!');

        // Redirect back to the same page
        return redirect()->back();
    }
}
