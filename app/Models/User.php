<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Role constants
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'country',
    ];

    /**
     * Attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'role' => self::ROLE_USER,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if the user has a specific role.
     *
     * @param  string  $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }


    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole(self::ROLE_ADMIN);
    }

    /**
     * Check if the user is a regular user.
     *
     * @return bool
     */
    public function isUser()
    {
        return $this->hasRole(self::ROLE_USER);
    }
}
