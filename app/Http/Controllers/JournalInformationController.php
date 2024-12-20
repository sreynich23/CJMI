<?php

namespace App\Http\Controllers;

use App\Models\JournalInformation;
use Illuminate\Http\Request;

class JournalInformationController extends Controller
{
    public function index()
    {
        $information = JournalInformation::first();
        return view('admin.journal-information.index', compact('information'));
    }

    public function edit()
    {
        $information = JournalInformation::first();
        return view('admin.journal-information.edit', compact('information'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'journal_name' => 'required|string|max:255',
            'telegram' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'editorial_office' => 'required|string|max:255',
            'license_text' => 'required|string',
            'developer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
        ]);

        $information = JournalInformation::first();
        if (!$information) {
            $information = new JournalInformation();
        }

        $information->fill($validated);
        $information->save();

        return redirect()->route('admin.journal-information.index')
            ->with('success', 'Journal information updated successfully');
    }

    public function show()
    {
        $information = JournalInformation::first();
        return view('journal-information', compact('information'));
    }
}
