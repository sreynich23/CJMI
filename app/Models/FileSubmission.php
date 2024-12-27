<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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
        'status',
        'reviewed_at'
    ];

    protected $casts = [
        'file_size' => 'integer',
        'version' => 'integer',
        'reviewed_at' => 'datetime'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFileUrl(): string
    {
        if (!$this->file_path) {
            return null;
        }

        // If using public disk
        if (Storage::disk('public')->exists($this->file_path)) {
            return Storage::url($this->file_path);
        }

        // If file is stored in local storage
        return Storage::url($this->file_path);
    }

    public function getFileSizeForHumans(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
