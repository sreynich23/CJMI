<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorialTeam extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'position', 'description', 'path_image'];
}
