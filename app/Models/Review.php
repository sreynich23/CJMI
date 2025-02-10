<?php

namespace App\Models;

use App\Http\Controllers\Admin\SubmissionController;
use CreateReviewersTable;
use CreateReviewerTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['submission_id', 'reviewer_id', 'feedback', 'status'];

    public function reviewer()
    {
        return $this->belongsTo(CreateReviewerTable::class);
    }

    public function submission()
    {
        return $this->belongsTo(SubmissionController::class);
    }
}
