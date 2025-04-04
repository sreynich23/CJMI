<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Conference;
use App\Models\Editor;
use App\Models\EditorialTeam;
use App\Models\Indexing;
use App\Models\JournalInformation;
use App\Models\JournalIssue;
use App\Models\Navbar;
use App\Models\PoliciesGuideline;
use App\Models\Recognition;
use App\Models\Reviewer;
use App\Models\User;
use App\Models\VolumeIssue;
use App\Models\VolumeIssueImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $navbar = Navbar::latest()->first();
        $recognitions = Recognition::all();
        $indexings = Indexing::all();
        $conferences = Conference::all();

        // If there is a query, search for articles that match the title or content
        if ($query) {
            $articles = Article::where('title', 'LIKE', '%' . $query . '%')
                ->get();
        } else {
            // Otherwise, show all articles
            $articles = Article::with('journalIssue')->latest()->limit(6)->get();
        }
        $image = VolumeIssueImage::latest()->first();
        $journalInfo = JournalInformation::first();
        // $articles = Article::with('journalIssue')->latest()->limit(5)->get();
        $latestYear = VolumeIssue::all();

        if (is_array($articles) || is_object($articles)) {
            return view('home', compact('journalInfo', 'articles', 'latestYear', 'image', 'navbar','recognitions', 'indexings', 'conferences'));
        } else {
            // Handle the case where $articles is not an array or object
        }
    }


    public function allEditorials()
    {
        $policies = PoliciesGuideline::all();
        $navbar = Navbar::latest()->first();
        $journalInfo = JournalInformation::first();
        $teamMembers = EditorialTeam::all()->groupBy('position');
        $reviewers = Reviewer::all();
        return view('all_editorial', compact('journalInfo', 'navbar','teamMembers', 'reviewers','policies'));
    }
    public function editorialTeam()
    {
        $navbar = Navbar::latest()->first();
        $journalInfo = JournalInformation::first();
        $teamMembers = EditorialTeam::all()->groupBy('position');
        $reviewers = Reviewer::all();
        return view('editorailTeam', compact('journalInfo', 'navbar','teamMembers', 'reviewers'));
    }
}
