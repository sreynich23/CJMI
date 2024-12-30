<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolumeIssueImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'volume_issue_id',
        'image_path',
    ];

    public function volumeIssue()
    {
        return $this->belongsTo(VolumeIssueImage::class);
    }
}
