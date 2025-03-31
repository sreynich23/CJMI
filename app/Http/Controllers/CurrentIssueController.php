<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\FileSubmission;
use App\Models\JournalIssue;
use App\Models\Navbar;
use App\Models\VolumeIssue;
use App\Models\VolumeIssueImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CurrentIssueController extends Controller
{
    public function index(Request $request)
    {
        $image = VolumeIssueImage::latest()->first();
        $navbar = Navbar::latest()->first();
        $latestYear = VolumeIssue::query()
            ->orderByDesc('created_at')
            ->first();
        $journalInfo = FileSubmission::with('issues')->first();
        $recentItems = DB::table('volume_issue')
            ->join('journal_issues', 'volume_issue.id', '=', 'journal_issues.id_volume_issue')
            ->select(
                'journal_issues.id',
                'journal_issues.publication_date',
                'journal_issues.title',
                'journal_issues.description',
                'journal_issues.created_at',
                'journal_issues.updated_at',
                'volume_issue.id AS id_volume_issue'
            )
            ->where('volume_issue.id', function ($query) {
                $query->select('id')
                    ->from('volume_issue')
                    ->orderByDesc('created_at')
                    ->limit(1);
            })
            ->get();
        return view('curr', [
            'journalInfo' => $journalInfo,
            'recentItems' => $recentItems,
            'previousVolume' => $previousVolume ?? null,
            'latestYear' => $latestYear,
            'navbar' => $navbar,
            'image' => $image,
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
        $latestYear = VolumeIssue::query()->max('year'); // Get the latest year for reference

        // Fetch all volumes with their issues, ordered by year, volume, and issue
        $volumes = VolumeIssue::query()
            ->select('id', 'volume', 'issue', 'year') // Select necessary fields
            ->orderBy('year', 'desc') // Order by year (descending)
            ->orderBy('volume', 'asc') // Then order by volume (ascending)
            ->orderBy('issue', 'asc') // Then order by issue (ascending)
            ->get();
        // Fetch images for each volume issue
        $volumeImages = VolumeIssueImage::query()
            ->whereIn('id_volume_issue', $volumes->pluck('id')) // Get images for volumes that exist
            ->get();

        // Group volumes by year
        $groupedVolumes = $volumes->groupBy('year');

        // Format the volumes for each year
        $formattedVolumes = [];
        foreach ($groupedVolumes as $year => $volumesByYear) {
            $formattedVolumes[$year] = $volumesByYear->map(function ($volume) use ($volumeImages) {
                // Get the image path for the current volume
                $imagePath = $volumeImages->where('id_volume_issue', $volume->id)->first()?->image_path;
                return [
                    'id_volume_issue' => $volume->id, // Include id_volume_issue
                    'volume' => 'Vol. ' . $volume->volume . ' Iss. ' . $volume->issue . ' (' . $volume->year . ')',
                    'image' => $imagePath,
                ];
            });
        }
        return view('all_volume', compact('formattedVolumes', 'latestYear', 'navbar'));
    }


    public function showVolumeIssueDetails($id)
    {
        $latestYear = VolumeIssue::query()->max('year');
        $navbar = Navbar::latest()->first();

        // Use the passed ID ($id) to filter JournalIssue records
        $data = JournalIssue::query()
            ->where('id_volume_issue', $id)
            ->with('articles')
            ->get();
        $volumeIssue = VolumeIssue::query()
            ->where('id', $id)
            ->first();
        $volumeImages = VolumeIssueImage::query()
            ->where('id_volume_issue', $id)
            ->get();
        // Return the view with the filtered data
        return view('volume_issue_details', compact('data', 'id','volumeImages','volumeIssue', 'latestYear', 'navbar'));
    }
}
