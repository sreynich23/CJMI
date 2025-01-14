<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Editorial;
use App\Models\Reviewer;
use App\Models\User;

class EditorialController extends Controller
{
    public function index()
    {
        $editorials = User::whereHas('user', function($query) {
            $query->where('role', 'admin');
        })->get();

        $reviewers = User::whereHas('user', function($query) {
            $query->where('role', 'reviewer');
        })->get();

        return view('all_editorial', compact('editorials', 'reviewers'));
    }
}
