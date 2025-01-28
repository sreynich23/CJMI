<?php
// app/Http/Controllers/AnnouncementsController.php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\JournalIssue;
use App\Models\Navbar;
use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    public function index()
    {
        $latestYear = JournalIssue::all();
        $navbar = Navbar::latest()->first();
        $announcements = Announcement::first();
        return view('announcements',compact('latestYear','navbar','announcements'));  // Make sure there's a corresponding view named 'announcements.blade.php'
    }

    public function showPage($pages)
    {
        return view('announcements', ['announcementsPage' => $pages]); // Assuming views are named after the route (e.g., 'editorial-team.blade.php')
    }
}

