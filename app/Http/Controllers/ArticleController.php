<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\JournalIssue;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show($id)
    {
        $article = Article::findOrFail($id);
        $latestYear = JournalIssue::query()->max('year');
        return view('articles.show', compact('article','latestYear'));
    }
}
