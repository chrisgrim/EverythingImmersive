<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    protected $fillable = [
    	'eventTitle','eventDescription','eventWebsite','eventPrice','eventTicketUrl','eventStreetNumber','eventCity','eventState','eventCountry','eventZipcode','slug','eventImagePath','thumbImagePath','eventLong','eventLat','user_id', 'eventStreetAddress', 'category_id', 'organizer_id', 'eventExpectations', 'approved',

    ];
    protected $appends = ['isFavorited'];

    public function organizer() 
    {
    	return $this->belongsTo(Organizer::class);
    }
    public function category() 
    {
        return $this->belongsTo(Category::class);
    }
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
    public function favorites() 
    {
        return $this->MorphMany(Favorite::class, 'favorited');
    }
    public function favorite()
    {
        $att = ['user_id' => auth()->id()];

        if (! $this->favorites()->where($att)->exists()) {
            $this->favorites()->create($att);
        }
    }
    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
    public function unFavorite()
    {
        return $this->favorites()->where('user_id', auth()->id())->delete();
    }

    public function getRouteKeyName()
    {
    	return 'slug';
    }
    public function scopeSimilarCity($query, $event)
    {
        return $query->where('eventCity', '=', $event->eventCity);
    }
    public function scopeUniqueCity($query, $event)
    {
        return $query->where('id', '!=', $event->id);
    }
}
