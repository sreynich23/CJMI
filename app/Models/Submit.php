<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submit extends Model
{
    protected $fillable = [
        'user_id',
        'prefix',
        'title',
        'subtitle',
        'abstract',
        'keywords',
        'file_path',
        'original_filename',
        'status',
        'comments'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function article(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function authors(): HasMany
    {
        return $this->hasMany(Author::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'under_review' => 'bg-blue-100 text-blue-800',
            'accepted' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
