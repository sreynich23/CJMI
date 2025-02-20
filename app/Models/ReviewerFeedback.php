<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewerFeedback extends Model
{
    use HasFactory;

    protected $table = 'reviewer_feedback';
    protected $fillable = [
        'submission_id',
        'reviewer_id',
        'comments',
        'recommendation',
        'file_path',
    ];

    public function submission()
    {
        return $this->belongsTo(Submit::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
