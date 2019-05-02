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
    public function updateOrCreate($data = [])
    {
        $data['user_id'] = auth()->id();
        $data['slug'] = str_slug($data['organizationName']) ;
        if (is_file($data['organizationImagePath'])) {
            $data['organizationImagePath'] = $data['organizationImagePath']->store('organizers', 'public');
        }
        if ($organizer = $this->find($data['id'])) {
            $organizer->update($data);
            return $organizer->fresh();
        } else {
            return $this->create($data);
        }

    }
    
}
