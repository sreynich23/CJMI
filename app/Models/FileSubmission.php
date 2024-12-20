<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileSubmission extends Model
{
    protected $fillable = [
        'article_id',
        'original_filename',
        'stored_filename',
        'file_path',
        'file_type',
        'file_size',
        'version',
        'status'
    ];

    protected $casts = [
        'file_size' => 'integer',
        'version' => 'integer',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function getFileUrl(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
