<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
        'name', 'email', 'password', 'avatar_path','image_path','provider','provider_id',
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
    public function favorites() 
    {
        return $this->hasMany(Favorite::class);
    }
    public function organization() 
    {
        return $this->hasOne(Organizer::class);
    }
    public function getRouteKeyName()
    {
        return 'name';
    }
    public function getAvatarPathAttribute($avatar)
    {
        $avatarStore='storage/'.$avatar;
        return asset($avatar ? $avatarStore : 'storage/default-avatar/default.png');
    }
    public function deleteUserImage()
    {
        if (auth()->user()->image_path!==NULL){
            Storage::delete('public/' . auth()->user()->image_path);
        }
    }
    public function Admin()
    {
        if ($this->type == 'admin')
        {
            return true;
        }
            return false;
    }
    public function Organizer()
    {
        if ($this->type == 'organizer')
        {
            return true;
        }
            return false;

    }
}
