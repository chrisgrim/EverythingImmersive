<?php

namespace App;

use App\Genre;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;
use App\Filters\EventFilter;

class Event extends Model
{
    protected $fillable = [
    	'eventTitle','eventDescription','eventWebsite','eventGeneralCost','eventTicketUrl','specificLocation','eventCity','eventState','eventCountry','eventZipcode','slug','eventImagePath','thumbImagePath','eventLong','eventLat','user_id', 'eventStreetAddress', 'category_id', 'organizer_id', 'eventExpectations', 'approved', 'wheelchairReady', 'mobilityAdvisories', 'contentAdvisories', 'sexualViolence', 'sexualViolenceDescription', 'contactAdvisoryDescription', 'overallRating', 'embargoDate', 'openingDate', 'closingDate', 'ageRestriction', 'eventSeniorCost', 'eventVIPCost', 'eventAllOtherCost', 'eventMilitaryCost', 'eventStudentCost', 'eventImage', 'cost'

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
        //get the new genres submitted on the page
        $genres = $request['eventGenre'];

        //go through them and if it exists then it does nothing, otherwise it will create a new genre
        foreach ($genres as $genre) {
            Genre::firstOrCreate(['genre' => $genre]);
        }

        //newSync is given all the objects where the name is the same as the submitted names
        $newSync = Genre::all()->whereIn('genre', $genres);
        
        //using laravels sync and belongsTo relationship we can easy add these to the event_genre table
        $this->genres()->sync($newSync);

        //update the event model with the request(it is full request because update has to be an array)
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
            
            //Create File Info
            $filename = $this->eventImageName($request);
            $imagePath = "event-images/$filename";
            $thumbnailPath = "thumb-images/thumb-$filename";

            //Store File
            $request->file('eventImage')->storeAs('/public/event-images', $filename);

            //Resize File   
            Image::make(storage_path()."/app/public/event-images/$filename")->fit(1200, 800)->save(storage_path("/app/public/$imagePath"))->fit(600, 400)->save(storage_path("/app/public/$thumbnailPath"));

            //Update Image Paths
            $this->update([
                    'eventImagePath' => $imagePath,
                    'thumbImagePath' => $thumbnailPath,
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

    // You can delete the scope filter, start from line 143 to 168

     public function scopePriceFilter($query, $param)
    {
        return $query->where('eventGeneralCost', '<=', $param);
    }
    public function scopeNameFilter($query, $param)
    {
        return $query->where('eventTitle', 'LIKE', $param);
    }
    public function scopeLocationLatFilter($query, $request, $radius = 20)
    {
        $latitude=$request->eventLat;
        $longitude=$request->eventLong;
        return $query->select('events.*')
                ->selectRaw('( 3959 * acos( cos( radians(?) ) *
                               cos( radians( eventLat ) )
                               * cos( radians( eventLong ) - radians(?)
                               ) + sin( radians(?) ) *
                               sin( radians( eventLat ) ) )
                             ) AS distance', [$latitude, $longitude, $latitude])
                ->havingRaw("distance < ?", [$radius]);
    }
    public function scopeLocationNameFilter($query, $request)
    {
        $locationName = $request->locationName;
        return $query->where('eventCity', '=', $locationName);
    }

    /**
     * Scope filter for events
     * 
     * @param $query
     * @param EventFilter $filter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, EventFilter $filter)
    {
        return $filter->apply($query);
    }
}
