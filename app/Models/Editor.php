<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'active'];

    /**
     * Define the relationship between Editor and Reviews.
     * An editor can have many reviews.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
