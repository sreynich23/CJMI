public function showSubmissions()
{
    $submissions = Submission::all();
    $reviewers = Reviewer::all(); // Assuming you have a Reviewer model

    return view('admin.pages.submitPage', compact('submissions', 'reviewers'));
}
