<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\JournalInformation;
use App\Models\JournalIssue;
use App\Models\VolumeIssueImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // If there is a query, search for articles that match the title or content
        if ($query) {
            $articles = Article::where('title', 'LIKE', '%' . $query . '%')
                                ->get();
        } else {
            // Otherwise, show all articles
            $articles = Article::with('journalIssue')->latest()->limit(5)->get();
        }
        $image = VolumeIssueImage::latest()->first();
        $journalInfo = JournalInformation::first();
        // $articles = Article::with('journalIssue')->latest()->limit(5)->get();
        $latestYear = JournalIssue::query()->max('year');
        return view('home', compact('journalInfo','articles','latestYear','image'));
    }
}
