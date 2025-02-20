<?php

namespace App\Http\Controllers;

use App\Models\FileSubmission;
use App\Models\Submit;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FileDownloadController extends Controller
{
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

        return Storage::download($filePath, $submit->title . '.docx');
    }

    public function show(FileSubmission $submission)
    {
        // Check if file exists
        if (!Storage::exists($submission->file_path)) {
            abort(404, 'File not found');
        }

        // Load related data
        $submission->load(['article.authors']);

        // If it's a direct view request (not AJAX)
        if (!request()->ajax()) {
            return view('manuscripts.show', compact('submission'));
        }

        // For AJAX requests or direct file viewing
        return response()->file(
            Storage::path($submission->file_path),
            ['Content-Type' => $submission->file_type]
        );
    }

    public function preview(FileSubmission $submission)
    {
        // Check if file exists
        if (!Storage::exists($submission->file_path)) {
            abort(404, 'File not found');
        }

        // Stream file for viewing
        return response()->file(
            Storage::path($submission->file_path),
            ['Content-Type' => $submission->file_type]
        );
    }
}
