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
        $latestYear = JournalIssue::query()->max('year');
        return view('articles.show', compact('article','latestYear','navbar','image'));
    }
}
