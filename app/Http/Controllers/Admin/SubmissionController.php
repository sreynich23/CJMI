<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\FileSubmission;
use App\Models\JournalInformation;
use App\Models\JournalIssue;
use App\Models\Submit;
use App\Models\VolumeIssue;
use App\Models\VolumeIssueImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = FileSubmission::with(['article'])
            ->orderBy('created_at', 'desc');
        // ->paginate(10);
        // dd($submissions);
        $journalInfo = JournalInformation::first();
        $recentItems = JournalIssue::orderBy('publication_date', 'desc');

        return view('admin.dashboard', compact('submissions', 'recentItems', 'journalInfo'));
    }

    public function show(FileSubmission $submission)
    {
        $submission->load('article.authors');
        return view('admin.submissions.show', compact('submission'));
    }

    public function update(Request $request, FileSubmission $submission)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected',
            'review_comments' => 'nullable|string'
        ]);

        $submission->update($validated);

        // Send notification to author about status change
        // TODO: Implement notification

        return redirect()
            ->route('admin.submissions.show', $submission)
            ->with('success', 'Submission status updated successfully');
    }
    public function approve($id)
    {
        $submission = Submit::findOrFail($id); // Fetch the submission by ID

        $submission->update(['status' => 'approved']); // Update the status to approved

        // Send email notification to the user
        try {
            Mail::to($submission->user->email)->send(new \App\Mail\SubmissionApproved($submission));
        } catch (\Exception $e) {
            // Log error if email fails
            Log::error('Failed to send approval email: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'Submission approved successfully, and an email notification has been sent.');
    }

    public function publicSubmission(Request $request)
    {
        // Validate the input for volume, issue, year, and cover image
        $request->validate([
            'year' => 'required|numeric|min:1900|max:' . date('Y'),
            'volume' => 'required|string|max:255',
            'issue' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate the cover image
        ]);

        // Create VolumeIssue first
        $volumeIssue = VolumeIssue::create([
            'volume' => $request->input('volume'),
            'issue' => $request->input('issue'),
            'year' => $request->input('year'),
        ]);

        // Handle the cover image upload if it exists
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $coverImagePath = $coverImage->store('covers'); // Store the image

            // Create a record in the volume_issue_images table
            VolumeIssueImage::create([
                'id_volume_issue' => $volumeIssue->id,
                'image_path' => $coverImagePath,
            ]);
        }

        // Fetch all the approved submissions
        $submissions = Submit::where('status', 'approved')->get();

        foreach ($submissions as $submission) {
            // Update the submission status to "publiced"
            $submission->update(['status' => 'publiced']);

            // Create JournalIssue for each submission
            $journalIssue = JournalIssue::create([
                'publication_date' => now(),
                'title' => $submission->title ?? 'Untitled',
                'description' => $submission->author_name ?? 'No description provided',
                'created_at' => now(),
                'updated_at' => now(),
                'id_volume_issue' => $volumeIssue->id, // Use the id of the latest VolumeIssue
            ]);

            // Ensure the PDF directory exists
            $pdfDirectory = storage_path('app/public/pdf_articles');
            if (!file_exists($pdfDirectory)) {
                mkdir($pdfDirectory, 0777, true);
            }

            // Get the file path of the submitted file
            $filePath = storage_path('app/public/' . $submission->file_path);
            $convertedPdfPath = $pdfDirectory . '/' . $submission->id . '.pdf';

            // Convert DOCX to PDF (if the file format is DOCX)
            if (strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === 'docx') {
                $domPdfPath = base_path('vendor/dompdf/dompdf');
                Settings::setPdfRendererPath($domPdfPath);
                Settings::setPdfRendererName('DomPDF');

                $phpWord = IOFactory::load($filePath);
                $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');
                $pdfWriter->save($convertedPdfPath);
            } else {
                return redirect()->back()->with('error', 'Unsupported file format for conversion.');
            }

            // Create the Article for each JournalIssue
            Article::create([
                'journal_issue_id' => $journalIssue->id,
                'title' => $submission->title,
                'subtitle' => $submission->subtitle, // Add subtitle
                'abstract' => $submission->abstract,
                'keywords' => $submission->keywords, // Add keywords
                'pdf_url' => 'pdf_articles/' . $submission->id . '.pdf', // Save the URL of the PDF
                'page' => 'Page ' . $submission->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Redirect back with success message
        return redirect()->back()->with('success', 'All submissions approved, converted to PDF, and added to Journal Issues successfully!');
    }

    public function reject(Request $request, $id)
    {
        $submission = Submit::findOrFail($id); // Fetch the submission by ID
        $submission->update(['status' => 'rejected']); // Update the status to rejected

        return redirect()->back()->with('success', 'Submission rejected successfully.');
    }
}
