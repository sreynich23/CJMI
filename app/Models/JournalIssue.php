<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalIssue extends Model
{
    use HasFactory;

    protected $fillable = ['volume', 'issue', 'publication_date', 'title', 'description'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}

