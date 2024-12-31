<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalIssue; // or the model you want to search

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Perform the search logic (e.g., searching through JournalIssue model)
        $results = JournalIssue::where('title', 'LIKE', '%' . $query . '%')
                            ->orWhere('content', 'LIKE', '%' . $query . '%')
                            ->get();

        return view('search.results', compact('results'));
    }
}

