<?php

namespace App\Http\Controllers;

use App\Models\JournalIssue;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $latestYear = JournalIssue::query()->max('year');
        return view('wigets.show_profile',compact('latestYear'));
    }
}
