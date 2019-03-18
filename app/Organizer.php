<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
	protected $fillable = [
		'organizationName', 'organizationDescription', 
	];
    
    public function events() 
    {
    	return $this->hasMany(Event::class);
    }
    public function likes() 
    {
        return $this->HasMany(Likes::class);
    }
}
