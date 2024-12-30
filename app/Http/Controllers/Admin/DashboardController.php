<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JournalInformation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $recentSubmissions = \App\Models\FileSubmission::latest()->take(5)->get();

        return view('admin.dashboard', compact('recentSubmissions'));
    }

    


}
