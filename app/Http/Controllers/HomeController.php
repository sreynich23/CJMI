<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\JournalInformation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $journalInfo = JournalInformation::first();
        $articles = Article::with('journalIssue')->latest()->limit(5)->get();
        dd($articles);
        return view('home', compact('journalInfo','articles'));
    }
}
