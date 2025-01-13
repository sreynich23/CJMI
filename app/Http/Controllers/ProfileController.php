<?php

namespace App\Http\Controllers;

use App\Models\JournalIssue;
use App\Models\Navbar;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $latestYear = JournalIssue::query()->max('year');
        $navbar = Navbar::latest()->first();
        return view('wigets.show_profile',compact('latestYear','navbar'));
    }
}
