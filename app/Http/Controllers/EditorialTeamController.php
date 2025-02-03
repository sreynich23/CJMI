<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EditorialTeam;

class EditorialTeamController extends Controller
{
    public function index()
    {
        $teamMembers = EditorialTeam::all();
        return view('editorial_team.index', compact('teamMembers'));
    }
}

