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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFileUrl(): string
    {
        return Storage::exists($this->file_path)
            ? Storage::url($this->file_path)
            : '#';
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
