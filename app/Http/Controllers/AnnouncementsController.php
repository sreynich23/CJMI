<?php
// app/Http/Controllers/AnnouncementsController.php

namespace App\Http\Controllers;

use App\Models\JournalIssue;
use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    public function index()
    {
        $latestYear = JournalIssue::query()->max('year');
        return view('announcements',compact('latestYear'));  // Make sure there's a corresponding view named 'announcements.blade.php'
    }

    public function showPage($pages)
    {
        return view('announcements', ['announcementsPage' => $pages]); // Assuming views are named after the route (e.g., 'editorial-team.blade.php')
    }
}

