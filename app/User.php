<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
        'name', 'email', 'password', 'avatar_path','image_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function events() 
    {
        return $this->hasMany(Event::class);
    }
    public function likes() 
    {
        return $this->hasMany(Like::class);
    }
    public function Admin()
    {
        if ($this->type == 'admin')
        {
            return true;
        }
            return false;
    }
}
