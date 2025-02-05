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
    ];

    protected $casts = [
        'publication_date' => 'date',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'journal_issue_id');
    }
    // In JournalIssue model
public function volumeIssueImages()
{
    return $this->hasMany(VolumeIssueImage::class);
}

}
