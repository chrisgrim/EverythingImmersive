<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
	protected $fillable = [
		'organizationName', 'organizationDescription','slug', 'organizer_id','instagramHandle','twitterHandle','facebookHandle','organizationRating','organizationImagePath','organizationWebsite','user_id', 'avatar',
	];
    
    public function events() 
    {
    	return $this->hasMany(Event::class);
    }
    public function likes() 
    {
        return $this->HasMany(Likes::class);
    }
    public function users() 
    {
        return $this->belongsTo(User::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
}
