<?php

namespace App\Http\Controllers;

use App\Models\PoliciesGuideline;
use Illuminate\Http\Request;

class PoliciesGuidelineController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'category' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        PoliciesGuideline::create($request->all());

        return redirect()->back()
            ->with('success', 'PoliciesGuideline created successfully.');
    }

    public function edit(Request $request,PoliciesGuideline $policies_guideline)
    {
        $request->validate([
            'type' => 'required',
            'category' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        $data = $request->only(['type', 'category', 'title', 'description']);
        $policies_guideline->update($data);
        return redirect()->back()
            ->with('success', 'PoliciesGuideline edit successfully.');
    }
}
