<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
		'eventRegion',
	];
    
    public function events() 
    {
    	return $this->belongsToMany(Event::class);
    }
}
