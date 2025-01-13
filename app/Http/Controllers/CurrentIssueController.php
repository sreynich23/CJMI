<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\FileSubmission;
use App\Models\JournalIssue;
use App\Models\Navbar;
use App\Models\VolumeIssueImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CurrentIssueController extends Controller
{
    public function index(Request $request)
    {
        $image = VolumeIssueImage::latest()->first();
        $navbar = Navbar::latest()->first();
        $issue = $request->query('issue');
        $volume = $request->query('volume');
        $year = $request->query('year');
        $latestYear = JournalIssue::query()->max('year');
        // Fetch journal info
        $journalInfo = FileSubmission::with('issues')->first(); // Replace with your actual query

        // Fetch recent items filtered by issue, volume, and year
        $recentItems = JournalIssue::query()
            ->when($issue, fn($query) => $query->where('issue', $issue))
            ->when($volume, fn($query) => $query->where('volume', $volume))
            ->when($year, fn($query) => $query->whereYear('publication_date', $year))
            ->orderBy('publication_date', 'desc')
            ->get();

        // Determine navigation values (Previous/Next Issue & Volume)
        $previousIssue = $issue > 1 ? $issue - 1 : null;
        $nextIssue = $issue ? $issue + 1 : null;

        // Determine next volume and year
        if ($volume) {
            if ($volume == 2) {
                // If volume is 2, navigate to the next year
                $nextVolume = null;
                $nextYear = $year + 1;
            } else {
                $nextVolume = $volume + 1;
            }
        } else {
            $nextVolume = 1; // Default to volume 1 if not set
        }

        // Determine previous volume and year
        if ($volume && $volume > 1) {
            $previousVolume = $volume - 1;
        } else {
            // If volume is 1, navigate to the previous year
            $previousVolume = null;
            if ($year > $latestYear) {
                $previousYear = $year - 1;
            }
        }


        return view('curr', [
            'journalInfo' => $journalInfo,
            'recentItems' => $recentItems,
            'previousIssue' => $previousIssue,
            'nextIssue' => $nextIssue,
            'previousVolume' => $previousVolume,
            'nextVolume' => $nextVolume,
            'latestYear' => $latestYear,
            'navbar' => $navbar,
            'image' => $image
        ]);
    }

    public function download($id)
    {
        $article = Article::findOrFail($id);

        if (!$article->pdf_url) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $filePath = 'public/' . $article->pdf_url;
        if (!Storage::exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::download($filePath, $article->title . '.pdf');
    }

    public function allVolumes()
    {
        $navbar = Navbar::latest()->first();
        $latestYear = JournalIssue::query()->max('year'); // Get the latest year for reference

        // Fetch all volumes with their issues, ordered by year and volume
        $volumes = JournalIssue::query()
            ->select('volume', 'issue', 'year', 'publication_date') // Select necessary fields
            ->orderBy('year', 'desc') // Order by year (descending)
            ->orderBy('volume', 'asc') // Then order by volume (ascending)
            ->orderBy('issue', 'asc') // Then order by issue (ascending)
            ->get()
            ->groupBy('volume'); // Group issues by volume for easier handling

        // Pass the data to the view
        return view('all_volume', compact('volumes', 'latestYear','navbar'));
    }
    public function showVolumeIssueDetails(Request $request)
    {
        $latestYear = JournalIssue::query()->max('year');
        $navbar = Navbar::latest()->first();
        // Retrieve the query parameters from the request
        $issue = $request->query('issue');
        $volume = $request->query('volume');
        $year = $request->query('year');

        // Query the database using the retrieved parameters
        $data = JournalIssue::query()
            ->when($issue, fn($query) => $query->where('issue', $issue))
            ->when($volume, fn($query) => $query->where('volume', $volume))
            ->whereYear('publication_date', $year)
            ->with('articles') // Assuming a relationship with articles or similar data
            ->get();

        // Return the view with the data
        return view('volume_issue_details', compact('data', 'volume', 'issue', 'year', 'latestYear','navbar'));
    }
}
