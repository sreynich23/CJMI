<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubmitController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;

// Add auth routes (includes login, register, password reset, etc)
Auth::routes();
// Authentication routes
Route::middleware(['web'])->group(function () {
    // Guest routes (login/register)
    Route::middleware(['guest'])->group(function () {
        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
    });

    // Auth required routes
    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});

Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/about', [AboutController::class, 'indexuser'])->name('about');

// Admin Dashboard
// Route::get('/', function () {
//     return view('admin.dashboard');
// })->name('admin.dashboard');

// About Management
// Route::get('/', [AboutController::class, 'index'])->name('abouts');
// Route::post('/about/store', [AboutController::class, 'store'])->name('about.store');
// Route::put('/{id}', [AboutController::class, 'update'])->name('update');
// Route::delete('/{id}', [AboutController::class, 'destroy'])->name('destroy');


// Submission Management
Route::get('/submissions', [SubmissionController::class, 'index'])->name('admin.submissions.index');
Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('admin.submissions.show');
Route::put('/submissions/{submission}', [SubmissionController::class, 'update'])->name('admin.submissions.update');
Route::get('/submit', [SubmitController::class, 'adminIndex'])->name('admin.submit');
Route::post('/submit/checklist', [SubmitController::class, 'storeChecklistItem'])->name('admin.submit.checklist.store');
Route::put('/submit/checklist/{id}', [SubmitController::class, 'updateChecklistItem'])->name('admin.submit.checklist.update');
Route::delete('/submit/checklist/{id}', [SubmitController::class, 'deleteChecklistItem'])->name('admin.submit.checklist.delete');
Route::put('/submit/contact', [SubmitController::class, 'updateContact'])->name('admin.submit.contact.update');
Route::put('/submit/policy', [SubmitController::class, 'updatePolicy'])->name('admin.submit.policy.update');

// Add the new route for curr page
Route::get('/curr', function () {
    return view('curr');
})->name('curr');

// Add the route for announcements page
Route::get('/announcements', function () {
    return view('announcements');
})->name('announcements');

// Submission System
Route::middleware(['auth'])->group(function () {
    Route::get('/submit', [SubmitController::class, 'index'])->name('submit.index');
    Route::post('/submit/manuscript', [SubmitController::class, 'submitManuscript'])->name('submit.manuscript');

    // Submission Wizard
    Route::prefix('submit')->name('submit.')->group(function () {
        Route::get('/step1', [SubmitController::class, 'showStep1'])->name('step1');
        Route::post('/step1', [SubmitController::class, 'saveStep1'])->name('saveStep1');
        Route::get('/step2', [SubmitController::class, 'showStep2'])->name('step2');
        Route::post('/step2', [SubmitController::class, 'saveStep2'])->name('saveStep2');
        Route::get('/step3', [SubmitController::class, 'showStep3'])->name('step3');
        Route::post('/step3', [SubmitController::class, 'saveStep3'])->name('saveStep3');
        Route::get('/step4', [SubmitController::class, 'showStep4'])->name('step4');
        Route::post('/step4', [SubmitController::class, 'saveStep4'])->name('saveStep4');
        Route::get('/step5', [SubmitController::class, 'showStep5'])->name('step5');
    });

    Route::get('/submissions', [SubmitController::class, 'indexSubmissions'])->name('submissions.index');
    Route::get('/submissions/{submit}', [SubmitController::class, 'showSubmission'])->name('submissions.show');
    Route::delete('/submissions/{submit}', [SubmitController::class, 'deleteSubmission'])->name('submissions.destroy');
});

// Add resource route for pages
Route::resource('pages', PageController::class);
