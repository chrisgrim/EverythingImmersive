<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactLevel extends Model
{
	protected $guarded = [
		
	];
	
    public function events() 
    {
    	return $this->belongsToMany(Event::class);
    }
}
