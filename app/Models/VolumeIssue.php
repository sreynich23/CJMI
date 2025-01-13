<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolumeIssue extends Model
{
    use HasFactory;

    protected $fillable = ['volume', 'issue', 'year'];
}

