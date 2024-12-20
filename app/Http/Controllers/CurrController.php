<?php

namespace App\Http\Controllers;

use App\Models\JournalInformation;
use Illuminate\Http\Request;

class CurrController extends Controller
{
    public function index()
    {
        $journalInfo = JournalInformation::first();
        return view('curr', compact('journalInfo'));
    }
}
