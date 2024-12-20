<?php

namespace App\Http\Controllers;

use App\Models\Submit;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SubmitController extends Controller
{
    protected $middleware = ['auth'];

    public function index()
    {
        return redirect()->route('submit.step1');
    }

    public function showStep1()
    {
        $checklistItems = ChecklistItem::all();
        return view('submit.step1', compact('checklistItems'));
    }

    public function submitManuscript(Request $request)
    {
        try {
            $request->validate([
                'prefix' => 'nullable|string|max:255',
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string|max:255',
                'abstract' => 'required|string',
                'keywords' => 'required|string',
                'manuscript' => 'required|file|mimes:doc,docx,pdf|max:10240',
            ]);

            // Handle file upload
            $file = $request->file('manuscript');
            $originalFilename = $file->getClientOriginalName();

            // Generate a unique filename
            $filename = time() . '_' . $originalFilename;

            // Store file in public/manuscripts directory
            $path = $file->move(public_path('manuscripts'), $filename);

            // Store relative path for database
            $relativePath = 'manuscripts/' . $filename;

            // Create submission
            $submit = Submit::create([
                'user_id' => Auth::id(),
                'prefix' => $request->prefix,
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'abstract' => $request->abstract,
                'keywords' => $request->keywords,
                'file_path' => $relativePath,
                'original_filename' => $originalFilename,
                'status' => 'pending',
            ]);

            return redirect()->route('submit.step5')
                ->with('success', 'Manuscript submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Submission error: ' . $e->getMessage());
            return back()->with('error', 'Failed to submit manuscript. Please try again.')
                ->withInput();
        }
    }

    public function saveStep1(Request $request)
    {
        $request->validate([
            'requirements' => 'required|array|min:5',
            'comments' => 'nullable|string|max:1000'
        ]);

        // Store submission data in session
        session(['submission.step1' => [
            'requirements' => $request->requirements,
            'comments' => $request->comments
        ]]);

        return redirect()->route('submit.step2');
    }

    public function saveStep2(Request $request)
    {
        $request->validate([
            'manuscript' => 'required|file|mimes:doc,docx,pdf|max:10240', // 10MB max
        ]);

        try {
            // Get the file from the request
            $file = $request->file('manuscript');
            $originalFilename = $file->getClientOriginalName();

            // Generate a unique filename
            $filename = time() . '_' . $originalFilename;

            // Store file in public/manuscripts directory
            $path = $file->move(public_path('manuscripts'), $filename);

            // Store relative path for database
            $relativePath = 'manuscripts/' . $filename;

            // Store file information in session
            session(['submission.step2' => [
                'file_path' => $relativePath,
                'original_filename' => $originalFilename
            ]]);

            return redirect()->route('submit.step3');
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            return back()->with('error', 'Failed to upload file. Please try again.')
                ->withInput();
        }
    }

    public function saveStep3(Request $request)
    {
        $request->validate([
            'prefix' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'abstract' => 'required|string',
            'keywords' => 'required|string',
        ]);

        // Store metadata in session
        session(['submission.step3' => [
            'metadata' => $request->only([
                'prefix',
                'title',
                'subtitle',
                'abstract',
                'keywords'
            ])
        ]]);

        return redirect()->route('submit.step4');
    }

    public function saveStep4(Request $request)
    {
        $request->validate([
            'confirm' => 'required|accepted'
        ]);

        try {
            // Get all submission data from session
            $submissionData = session('submission');

            // Validate that we have all required session data
            if (
                !isset($submissionData['step1']) ||
                !isset($submissionData['step2']) ||
                !isset($submissionData['step3'])
            ) {
                throw new \Exception('Missing submission data. Please start over.');
            }

            // Create the submission
            $submit = Submit::create([
                'user_id' => Auth::id(),
                'prefix' => $submissionData['step3']['metadata']['prefix'] ?? null,
                'title' => $submissionData['step3']['metadata']['title'],
                'subtitle' => $submissionData['step3']['metadata']['subtitle'] ?? null,
                'abstract' => $submissionData['step3']['metadata']['abstract'],
                'keywords' => $submissionData['step3']['metadata']['keywords'],
                'file_path' => $submissionData['step2']['file_path'],
                'original_filename' => $submissionData['step2']['original_filename'],
                'status' => 'pending',
                'comments' => $submissionData['step1']['comments'] ?? null,
            ]);

            if (!$submit) {
                throw new \Exception('Failed to create submission record.');
            }

            // Clear submission data from session only after successful creation
            session()->forget('submission');

            return redirect()->route('submit.step5')
                ->with('success', 'Your submission has been successfully completed!');
        } catch (\Exception $e) {
            Log::error('Submission error: ', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
                'session_data' => session('submission')
            ]);

            return back()
                ->with('error', 'Failed to complete submission: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function showStep2()
    {
        return view('submit.step2');
    }

    public function showStep3()
    {
        $submission = session('submission', []);
        return view('submit.step3', compact('submission'));
    }

    public function showStep4()
    {
        return view('submit.step4');
    }

    public function showStep5()
    {
        return view('submit.step5');
    }

    public function indexSubmissions(Request $request)
    {
        $query = Submit::query()
            ->where('user_id', Auth::id())
            ->with('user');

        // Handle search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('abstract', 'like', "%{$search}%");
            });
        }

        // Handle tab filtering
        $tab = $request->get('tab', 'my-queue');
        if ($tab === 'my-queue') {
            $query->where('status', 'pending');
        } else {
            $query->where('status', '!=', 'pending');
        }

        $submissions = $query->latest()->paginate(10);
        $myQueueCount = Submit::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        return view('submissions.index', compact('submissions', 'myQueueCount'));
    }

    public function deleteSubmission(Submit $submit)
    {
        try {
            // Check if user owns this submission
            if ($submit->user_id !== Auth::id()) {
                return back()->with('error', 'You are not authorized to delete this submission.');
            }

            // Delete the file if it exists
            if ($submit->file_path && file_exists(public_path($submit->file_path))) {
                unlink(public_path($submit->file_path));
            }

            // Delete the submission
            $submit->delete();

            return redirect()->route('submissions.index')
                ->with('success', 'Submission deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Submission deletion error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete submission. Please try again.');
        }
    }

    public function showSubmission(Submit $submit)
    {
        // Check if user owns this submission
        if ($submit->user_id !== Auth::id()) {
            return back()->with('error', 'You are not authorized to view this submission.');
        }

        return view('submissions.show', compact('submit'));
    }
}
