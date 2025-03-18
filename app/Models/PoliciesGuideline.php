<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliciesGuideline extends Model
{
    use HasFactory;

    protected $table = 'policies_guidelines';

    protected $fillable = [
        'type',
        'category',
        'title',
        'description',
    ];
}
