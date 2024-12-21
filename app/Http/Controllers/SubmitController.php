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
    public function index()
    {
        return redirect()->route('submit.step1');
    }

    // Step 1: Initial Requirements
    public function showStep1()
    {
        $checklistItems = ChecklistItem::all();
        return view('submit.step1', compact('checklistItems'));
    }

    public function saveStep1(Request $request)
    {
        $request->validate([
            'requirements' => 'required|array|min:5',
            'comments' => 'nullable|string'
        ]);

        $request->session()->put('submission.requirements', $request->requirements);
        $request->session()->put('submission.comments', $request->comments);

        return redirect()->route('submit.step2');
    }

    // Step 2: File Upload
    public function showStep2()
    {
        if (!session()->has('submission.requirements')) {
            return redirect()->route('submit.step1')
                ->with('error', 'Please complete step 1 first');
        }
        return view('submit.step2');
    }

    public function saveStep2(Request $request)
    {
        $request->validate([
            'manuscript' => 'required|file|mimes:doc,docx,pdf|max:10240', // 10MB max
        ]);

        try {
            $file = $request->file('manuscript');
            $path = $file->store('manuscripts', 'public');

            if (!$path) {
                throw new \Exception('Failed to store file');
            }

            $request->session()->put('submission.file_path', $path);
            $request->session()->put('submission.original_filename', $file->getClientOriginalName());

            return redirect()->route('submit.step3');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload file. Please try again.');
        }
    }

    // Step 3: Metadata
    public function showStep3()
    {
        if (!session()->has('submission.file_path')) {
            return redirect()->route('submit.step2')
                ->with('error', 'Please upload your manuscript first');
        }

        // Get the current submission data
        $submission = [
            'file_path' => session('submission.file_path'),
            'original_filename' => session('submission.original_filename'),
            'metadata' => session('submission.metadata', []),
        ];

        return view('submit.step3', compact('submission'));
    }

    public function saveStep3(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'abstract' => 'required|string|min:100',
                'keywords' => 'required|string|max:255',
                'prefix' => 'nullable|string|max:10',
                'subtitle' => 'nullable|string|max:255',
            ]);

            // Store metadata in session
            $request->session()->put('submission.metadata', $validated);

            return redirect()->route('submit.step4');
        } catch (\Exception $e) {
            Log::error('Step 3 save failed: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to save metadata. Please try again.']);
        }
    }

    // Step 4: Review & Confirm
    public function showStep4()
    {
        if (!session()->has('submission.metadata')) {
            return redirect()->route('submit.step3')
                ->with('error', 'Please complete the metadata first');
        }

        $submission = [
            'file' => session('submission.file_path'),
            'original_filename' => session('submission.original_filename'),
            'metadata' => session('submission.metadata'),
            'comments' => session('submission.comments'),
        ];

        return view('submit.step4', compact('submission'));
    }

    public function saveStep4(Request $request)
    {
        $request->validate([
            'confirm' => 'required|accepted'
        ]);

        try {
            $submission = Submit::create([
                'user_id' => Auth::id(),
                'prefix' => session('submission.metadata.prefix'),
                'title' => session('submission.metadata.title'),
                'subtitle' => session('submission.metadata.subtitle'),
                'abstract' => session('submission.metadata.abstract'),
                'keywords' => session('submission.metadata.keywords'),
                'file_path' => session('submission.file_path'),
                'original_filename' => session('submission.original_filename'),
                'status' => 'pending',
                'comments' => session('submission.comments'),
            ]);

            if (!$submission) {
                throw new \Exception('Failed to create submission record');
            }

            $request->session()->forget('submission');
            $request->session()->put('submission.completed', true);

            return redirect()->route('submit.step5')
                ->with('success', 'Your manuscript has been submitted successfully');
        } catch (\Exception $e) {
            Log::error('Submission failed: ' . $e->getMessage());

            if (session()->has('submission.file_path')) {
                Storage::delete(session('submission.file_path'));
            }

            return back()->with('error', 'Failed to submit manuscript. Please try again.');
        }
    }

    // Step 5: Completion
    public function showStep5()
    {
        if (!session()->has('submission.completed')) {
            return redirect()->route('submit.step4')
                ->with('error', 'Please complete your submission first');
        }
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

