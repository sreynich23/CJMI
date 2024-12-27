<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SubmitController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\AdminSubmissionsController;
use App\Http\Controllers\CurrentIssueController;
use App\Http\Controllers\FileDownloadController;

// Authentication Routes
Auth::routes();

// Public Routes
Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('/about', [AboutController::class, 'indexuser'])->name('about');
    Route::get('/curr', [CurrentIssueController::class, 'index'])->name('curr');
    Route::get('/announcements', [AnnouncementsController::class, 'index'])->name('announcements');
    Route::get('/current-issue', [CurrentIssueController::class, 'index'])->name('current-issue');
});

// Guest Routes (Only for non-authenticated users)
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    // Submission Wizard for Users
    Route::prefix('submit')->name('submit.')->group(function () {
        Route::get('/', [SubmitController::class, 'index'])->name('index');
        Route::post('/manuscript', [SubmitController::class, 'submitManuscript'])->name('manuscript');
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

    // User Submissions
    Route::prefix('submissions')->name('submissions.')->group(function () {
        Route::get('/', [SubmitController::class, 'indexSubmissions'])->name('index');
        Route::get('/{submit}', [SubmitController::class, 'showSubmission'])->name('show');
        Route::delete('/{submit}', [SubmitController::class, 'deleteSubmission'])->name('destroy');
    });
});

// Admin Routes
Route::middleware(AdminMiddleware::class)->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // About Management
    Route::get('/', [AboutController::class, 'index'])->name('about');
    Route::post('/about/store', [AboutController::class, 'store'])->name('about.store');
    Route::put('/about/{id}', [AboutController::class, 'update'])->name('about.update');
    Route::delete('/about/{id}', [AboutController::class, 'destroy'])->name('about.destroy');

    // Submissions Management
    Route::get('/', [AboutController::class, 'index'])->name('submissions');
    Route::post('/submissions/{submission}/approve', [AboutController::class, 'approve'])->name('submissions.approve');
    Route::post('/submissions/{submission}/reject', [AboutController::class, 'reject'])->name('submissions.reject');


    // Submission System Admin-Specific
    Route::prefix('submit')->name('submit.')->group(function () {
        Route::get('/', [SubmitController::class, 'adminIndex'])->name('index');
        Route::post('/checklist', [SubmitController::class, 'storeChecklistItem'])->name('checklist.store');
        Route::put('/checklist/{id}', [SubmitController::class, 'updateChecklistItem'])->name('checklist.update');
        Route::delete('/checklist/{id}', [SubmitController::class, 'deleteChecklistItem'])->name('checklist.delete');
        Route::put('/contact', [SubmitController::class, 'updateContact'])->name('contact.update');
        Route::put('/policy', [SubmitController::class, 'updatePolicy'])->name('policy.update');
    });
});


// Resource Route for Pages
Route::resource('pages', PageController::class);

// File Download Routes
Route::get('/files/{submission}/download', [FileDownloadController::class, 'download'])
    ->name('files.download');
Route::get('/files/{submission}/view', [FileDownloadController::class, 'show'])
    ->name('files.show');
Route::get('/files/{submission}/preview', [FileDownloadController::class, 'preview'])
    ->name('files.preview');
