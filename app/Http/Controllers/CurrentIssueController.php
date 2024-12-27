<?php

namespace App\Http\Controllers;

use App\Models\Submit;
use App\Models\Journal;
use App\Models\JournalIssue;

class CurrentIssueController extends Controller
{
    public function index()
    {
        // Get journal info
        $journalInfo = JournalIssue::first();

        // Get submissions that are accepted and published
        $articles = Submit::with(['user', 'authors'])
            ->where('status', 'accepted')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('curr', compact('journalInfo', 'articles'));
    }
}
