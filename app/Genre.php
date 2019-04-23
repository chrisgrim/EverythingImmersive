<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $guarded = [
		
	];
    
    public function events() 
    {
    	return $this->belongsToMany(Event::class);
    }
}
