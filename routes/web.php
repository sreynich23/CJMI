<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\DashboardController;
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
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CurrController;
use App\Http\Controllers\CurrentIssueController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JournalInformationController;
use App\Http\Controllers\ReviewerFeedbackController;
use App\Models\JournalIssue;
use App\Models\Navbar;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\reviewer;
use App\Http\Controllers\ReviewerController;
use App\Models\VolumeIssue;

// Authentication Routes
Auth::routes();

// Public Routes
Route::middleware(['web'])->group(function () {
    // Route::get('/', function () {
    //     return view('home');
    // })->name('home');
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [AboutController::class, 'indexuser'])->name('about');
    Route::get('/curr', [CurrentIssueController::class, 'index'])->name('curr');
    Route::get('/announcements', [AnnouncementsController::class, 'index'])->name('announcements');
    Route::get('/current-issue', [CurrentIssueController::class, 'index'])->name('current-issue');
    Route::get('/all_volumes', [CurrentIssueController::class, 'allVolumes'])->name('all_volumes');
    Route::get('/VolumeIssue/{id}', [CurrentIssueController::class, 'showVolumeIssueDetails'])->name('volume.issue.details');
    Route::get('/reviewer', [ReviewerController::class, 'index'])->name('reviewer');
    Route::post('/reviewer/feedback/{id}', [ReviewerFeedbackController::class, 'storeFeedback'])->name('reviewer.feedback');
    Route::get('/all-editorials', [HomeController::class, 'allEditorials'])->name('all-editorials');
    Route::post('/all-editorials/create', [ReviewerController::class, 'requestRoleChange'])->name('reviewer.create');
    Route::get('/files/{id}/download', [CurrentIssueController::class, 'download'])->name('download');
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
    Route::get('/allEditorial', [HomeController::class, 'allEditorials']);
    $navbar = Navbar::latest()->first();
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/request-role-change', [ReviewerController::class, 'requestRoleChange']);

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
        Route::get('/updateSubmit/{submission}', [SubmitController::class, 'edit'])->name('updateSubmit');
        Route::post('/update/{submission}', [SubmitController::class, 'updateSubmit'])->name('updateSubmited');
    });

    // User Submissions
    Route::prefix('submissions')->name('submissions.')->group(function () {
        Route::get('/', [SubmitController::class, 'indexSubmissions'])->name('index');
        Route::get('/{submit}', [SubmitController::class, 'showSubmission'])->name('show');
        Route::delete('/{submit}', [SubmitController::class, 'deleteSubmission'])->name('destroy');
    });

    // Admin Routes
    Route::middleware(AdminMiddleware::class)->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // About Management
        Route::post('/upload-cover', [DashboardController::class, 'uploadCover'])->name('uploadCover');
        Route::get('/', [AboutController::class, 'index'])->name('about');
        Route::post('/about/store', [AboutController::class, 'store'])->name('about.store');
        Route::put('/about/{id}', [AboutController::class, 'update'])->name('about.update');
        Route::delete('/about/{id}', [AboutController::class, 'destroy'])->name('about.destroy');
        Route::post('/updateJournalInfo', [AboutController::class, 'updateJournalInfo'])->name('about.updateJournalInfo');
        Route::post('/updateAnnouncement', [AboutController::class, 'updateAnnouncements'])->name('about.updateAnnouncements');
        Route::post('/updateNavbar', [AboutController::class, 'updateNavbar'])->name('navbar.update');
        Route::get('/VolumeIssue/{id}', [AboutController::class, 'showVolumeIssueDetails'])->name('volume.issue.details');

        // Submissions Management
        // Route::get('/', [AboutController::class, 'index'])->name('submissions');
        Route::post('/submissions/{submission}/approve', [SubmissionController::class, 'approve'])->name('submissions.approve');
        Route::post('/submissions/{submission}/reject', [SubmissionController::class, 'reject'])->name('submissions.reject');

        // Reviewer Management
        Route::get('/reviewers', [ReviewerFeedbackController::class, 'index'])->name('reviewers.index');
        Route::post('/assign-reviewers', [ReviewerController::class, 'assign_reviewers'])->name('reviewers.assign');
        Route::post('/reviewers/feedback', [ReviewerFeedbackController::class, 'storeFeedback'])->name('reviewers.feedback.store');

        // Submission System Admin-Specific
        Route::prefix('submit')->name('submit.')->group(function () {
            Route::get('/', [SubmitController::class, 'adminIndex'])->name('index');
            Route::post('/checklist', [SubmitController::class, 'storeChecklistItem'])->name('checklist.store');
            Route::put('/checklist/{id}', [SubmitController::class, 'updateChecklistItem'])->name('checklist.update');
            Route::delete('/checklist/{id}', [SubmitController::class, 'deleteChecklistItem'])->name('checklist.delete');
            Route::put('/contact', [SubmitController::class, 'updateContact'])->name('contact.update');
            Route::put('/policy', [SubmitController::class, 'updatePolicy'])->name('policy.update');
        });
        //mails
        Route::get('/reviewer/approve/{id}', [ReviewerController::class, 'approveReviewer'])->name('reviewer.approve');
        Route::post('/feedback/send/{authorId}/{submissionId}', [AboutController::class, 'sendReviewFeedback'])->name('feedback.send');
        Route::post('/accept/{authorId}/{submissionId}', [AboutController::class, 'acceptReview'])->name('accept.send');
        Route::post('/reject/{authorId}/{submissionId}', [AboutController::class, 'reject'])->name('reject.send');
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

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('send-otp');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password');
