<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolumeIssueImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'volume',
        'issue',
        'year',
        'image_path',
    ];

    public function volumeIssue()
    {
        return $this->belongsTo(VolumeIssueImage::class);
    }

    // In VolumeIssueImage model
public function journalIssue()
{
    return $this->belongsTo(JournalIssue::class); // Inverse relation
}

}
