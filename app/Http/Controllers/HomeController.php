<?php

namespace App\Http\Controllers;

use App\Models\JournalInformation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $journalInfo = JournalInformation::first();
        return view('home', compact('journalInfo'));
    }
} 
