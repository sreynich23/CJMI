<?php

namespace App\Http\Controllers;

use App\Models\FileSubmission;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FileDownloadController extends Controller
{
    public function download(FileSubmission $submission)
    {
        dd($submission);
        // Check if file exists
        if (!Storage::exists($submission->file_path)) {
            abort(404, 'File not found');
        }

        // Return file download response with original filename
        return Storage::download(
            $submission->file_path,
            $submission->original_filename,
            ['Content-Type' => $submission->file_type]
        );
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
