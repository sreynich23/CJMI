<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalIssue extends Model
{
    protected $fillable = [
        'title',
        'description',
        'year',
        'volume',
        'issue',
        'publication_date',
    ];

    protected $casts = [
        'publication_date' => 'date',
    ];
}
