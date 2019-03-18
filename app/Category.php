<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public function events() 
    {
    	return $this->hasMany(Event::class);
    }
    public function getRouteKeyName()
    {
    	return 'slug';
    }
}
