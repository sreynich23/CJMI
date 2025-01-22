<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Editor;
use App\Models\JournalInformation;
use App\Models\JournalIssue;
use App\Models\Navbar;
use App\Models\Reviewer;
use App\Models\User;
use App\Models\VolumeIssueImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $navbar = Navbar::latest()->first();

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

        if (is_array($articles) || is_object($articles)) {
            return view('home', compact('journalInfo', 'articles', 'latestYear', 'image', 'navbar'));
        } else {
            // Handle the case where $articles is not an array or object
        }
    }


    public function allEditorials()
    {
        $navbar = Navbar::latest()->first();
        $journalInfo = JournalInformation::first();
        $latestYear = JournalIssue::query()->max('year');
        $editorials = User::where('role','admin')->get();
        $users = User::all();
        $reviewers = Reviewer::all();
        return view('all_editorial', compact('journalInfo', 'latestYear', 'navbar', 'reviewers', 'users', 'editorials'));
    }
}
