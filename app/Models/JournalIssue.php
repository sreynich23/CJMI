<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalIssue extends Model
{
    protected $fillable = [
        'title',
        'description',
        'id_volume_issue',
        'publication_date',
        'year',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'publication_date' => 'date',
    ];

    // Relationship with Articles
    public function articles()
    {
        return $this->hasMany(Article::class, 'journal_issue_id');
    }

    // Relationship with VolumeIssueImages
    public function volumeIssueImages()
    {
        return $this->hasMany(VolumeIssueImage::class, 'id_volume_issue');
    }

    // Relationship with VolumeIssue (optional, if needed)
    public function volumeIssue()
    {
        return $this->belongsTo(VolumeIssue::class, 'id_volume_issue');
    }
}
