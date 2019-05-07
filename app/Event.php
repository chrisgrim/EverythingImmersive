<?php

namespace App;

use App\Genre;
use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    protected $fillable = [
    	'eventTitle','eventDescription','eventWebsite','eventGeneralCost','eventTicketUrl','specificLocation','eventCity','eventState','eventCountry','eventZipcode','slug','eventImagePath','thumbImagePath','eventLong','eventLat','user_id', 'eventStreetAddress', 'category_id', 'organizer_id', 'eventExpectations', 'approved', 'wheelchairReady', 'mobilityAdvisories', 'contentAdvisories', 'sexualViolence', 'sexualViolenceDescription', 'contactAdvisoryDescription', 'overallRating', 'embargoDate', 'openingDate', 'closingDate', 'ageRestriction', 'eventSeniorCost', 'eventVIPCost', 'eventAllOtherCost', 'eventMilitaryCost', 'eventStudentCost', 'eventImage',

    ];
    protected $appends = ['isFavorited'];

    public function organizer() 
    {
    	return $this->belongsTo(Organizer::class);
    }
    public function regions() 
    {
        return $this->belongsToMany(Region::class);
    }
    public function contactlevels() 
    {
        return $this->belongsToMany(ContactLevel::class);
    }
    public function genres() 
    {
        return $this->belongsToMany(Genre::class);
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
    public function isCompleted()
    {
        $attributes = ['eventTitle','eventDescription','eventWebsite','eventPrice','eventTicketUrl','eventCity','slug','eventImagePath','thumbImagePath','user_id', 'category_id', 'organizer_id', 'eventExpectations', 'immersiveScore'];
        foreach ($attributes as $attribute) {
            return !empty($this->$attribute);
        }
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
    public function updateDescription($request)
    {
        $genres = $request['eventGenre'];

        foreach ($genres as $genre) {
            Genre::firstOrCreate(['genre' => $genre]);
        }
        $newSync = Genre::all()->whereIn('genre', $genres);
        $this->genres()->sync($newSync);
        $this->update($request);
    }
    public function updateTitle($request)
    {
        $this->update([
            'eventTitle' => request('eventTitle'),
            'slug' => str_slug(request('eventTitle')),
        ]);
    }
    public function storeEventImage($request)
    {
        if ($request->hasFile('eventImage')) {
            $filename = $this->eventImageName($request);

            $request->file('eventImage')->storeAs('/public/event-images', $filename);
                $large = storage_path().'/app/public/event-images/'.$filename;
                $small = storage_path().'/app/public/thumb-images/'.'thumb'.'-'.$filename;
                Image::make($large)->fit(1200, 800)->save($large)->fit(600, 400)->save($small);

            $this->update([
                    'eventImagePath' => 'event-images/' . $filename,
                    'thumbImagePath' => 'thumb-images/'.'thumb'.'-'.$filename,
            ]);
        }
    }
    public function eventImageName($request)
    {
        $title = $this->slug;
        $extension = $request->file('eventImage')->getClientOriginalExtension();
        $fileNameToStore= $title.'.'.$extension;
        return $fileNameToStore;
    }
}
