<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['journal_issue_id', 'title', 'abstract', 'pdf_url'];

    public function journalIssue(): BelongsTo
    {
        return $this->belongsTo(JournalIssue::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'article_authors');
    }

    public function files(): HasMany
    {
        return $this->hasMany(FileSubmission::class);
    }

    public function getLatestFile(): ?FileSubmission
    {
        return $this->files()->latest()->first();
    }

    public function getApprovedFile(): ?FileSubmission
    {
        return $this->files()->where('status', 'approved')->latest()->first();
    }
}

