<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\JournalIssue;
use App\Models\Navbar;
use App\Models\VolumeIssueImage;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show($id)
    {
        $article = Article::findOrFail($id);
        $image = VolumeIssueImage::latest()->first();
        $navbar = Navbar::latest()->first();
        $latestYear = JournalIssue::all();
        return view('articles.show', compact('article', 'latestYear', 'navbar', 'image'));
    }
    public function search(Request $request)
    {
        $image = VolumeIssueImage::latest()->first();
        $navbar = Navbar::latest()->first();
        $latestYear = JournalIssue::all();
        $query = $request->input('query');
        $articles = Article::where('title', 'LIKE', "%$query%")->get();
        return view('search', compact('articles', 'latestYear', 'navbar', 'image'));
    }
}
