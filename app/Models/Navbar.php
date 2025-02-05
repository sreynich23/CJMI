<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
{
    use HasFactory;

    protected $table = 'navbars';

    protected $fillable = [
        'logo_path',
        'title',
        'background_color',
    ];
}
