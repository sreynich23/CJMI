<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolumeIssueImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'volume_issue_id', // Updated to volume_issue_id
        'image_path',
        'created_at',
        'updated_at',
    ];

    // Relationship with VolumeIssue
    public function volumeIssue()
    {
        return $this->belongsTo(VolumeIssue::class, 'volume_issue_id');
    }

    // Relationship with JournalIssue (if needed)
    public function journalIssue()
    {
        return $this->belongsTo(JournalIssue::class, 'volume_issue_id');
    }
}
