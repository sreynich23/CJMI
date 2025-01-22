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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['submission_id', 'reviewer_id', 'feedback', 'status'];

    /**
     * Define the relationship between Review and Reviewer.
     * A review belongs to one reviewer.
     */
    public function reviewer()
    {
        return $this->belongsTo(CreateReviewerTable::class);
    }

    /**
     * Define the relationship between Review and Submission.
     * A review belongs to one submission.
     */
    public function submission()
    {
        return $this->belongsTo(SubmissionController::class);
    }
}
