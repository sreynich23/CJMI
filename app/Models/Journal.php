<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'journal_name',
        'current_volume',
        'current_issue',
        'description'
    ];
}
