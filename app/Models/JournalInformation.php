<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_name',
        'telegram',
        'email',
        'editorial_office',
        'license_text',
        'developer',
        'publisher'
    ];
}
