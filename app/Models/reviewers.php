<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviewers extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reviewers';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reviewer_id',
        'submission_id',
        'status',
    ];

    /**
     * Define a relationship with the Article model.
     */
    public function submission()
{
    return $this->belongsTo(FileSubmission::class, 'submission_id');
}


    /**
     * Define a relationship with the User model (assuming the reviewer is a user).
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
