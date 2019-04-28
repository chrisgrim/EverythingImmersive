<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Region;
use App\Genre;
use App\ContactLevel;
use App\Organizer;
use App\User;
use App\Category;
use Intervention\Image\ImageManagerStatic as Image;

class CreatingEventsController extends Controller
{
    public function __construct(Event $event)
    {
        $this->middleware('auth');
    }

    public function editEvents()
    {
        $events = User::find(Auth()->id())->events;

        return view('events.create.editEvents', compact('events'));
    }

    public function createLocation(Event $event)
    {
        $regions = Region::all();
        $pivots = $event->regions()->get();

    	return view('events.create.Create_Location', compact('event','regions','pivots'));
    }

    public function updateLocation(Request $request, Event $event)
    {
    	$event->update(request()->validate([
    		'eventCity' => 'required',
            'eventState' => 'required',
            'eventStreetAddress' => 'required',
            'specificLocation' => 'required',
            'eventCountry' => 'required',
            'eventZipcode' => 'required',
    	]));

        $event->regions()->sync(request('eventRegion'));


    }

		// ------------------------------------------------------

    public function createCategory(Event $event)
    {
        $categories = Category::latest()->get();
        $event->load('category');

    	return view('events.create.Create_Category', compact('event', 'categories'));
    }
    public function updateCategory(Request $request, Event $event)
    {
    	$event->update(request()->validate([
    		'category_id' => 'required'
    	]));

    	return redirect('/create-your-event/'.$event->slug.'/organizer')->with(compact('event'));
    }

    // ------------------------------------------------------

    public function createOrganizer(Event $event)
    {
        $event->load('organizer');
        $organizers = Organizer::all();
    	return view('events.create.Create_Organizer', compact('event', 'organizers'));
    }

    public function storeOrganizer(Request $request, Event $event, Organizer $organizer)
    {
        $organizer = organizer::firstOrNew(request()->validate([
            'organizationName' => 'required',
            'organizationDescription' => 'required',
            'instagramHandle' => 'min:3',
            'twitterHandle' => 'min:3',
            'facebookHandle' => 'min:3',
            'organizationWebsite' => 'required',
        ]) + ['slug'=> str_slug(request('organizationName'))]);

        if (!Organizer::where('slug', str_slug(request('organizationName')))->exists()) {
            $this->validate(request(), [
                'organizationImagePath' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1048',
            ]);
            $path = $request->file('organizationImagePath')->store('organizers', 'public');
            $organizer->fill(['organizationImagePath' => $path]);
        }

        $organizer->fill(['user_id'=> auth()->id()]);

        $organizer->save();

    	$event->update(['organizer_id' => $organizer->id]);
    }

// ------------------------------------------------------

    public function createDates(Event $event)
    {
        return view('events.create.Create_Dates', compact('event'));
    }

    public function updateDates(Request $request, Event $event)
    {
        $event->update(request()->validate([
            'openingDate' => 'required',
            'closingDate' => 'required',
        ]));

    }

    // ------------------------------------------------------


    public function createDetails(Event $event)
    {
        return view('events.create.Create_Details', compact('event'));
    }

    public function updateDetails(Request $request, Event $event)
    {
        $event->update(request()->validate([
            'ageRestriction' => 'required',
            'eventGeneralCost' => 'required',
            'eventWebsite' => 'required',
            'eventTicketUrl' => 'required',
            'eventStudentCost' => '',
            'eventMilitaryCost' => '',
            'eventSeniorCost' => '',
            'eventVIPCost' => '',
            'eventAllOtherCost' => '',
        ]));
    }

     // ------------------------------------------------------

    public function createDescription(Event $event)
    {
        $pivots = $event->genres()->get();
        $genres = Genre::all();

        return view('events.create.Create_Description', compact('event','genres','pivots'));
    }

    public function updateDescription(Request $request, Event $event)
    {
        $event->update(request()->validate([
            'eventDescription' => 'required',
        ]));

        $genres = $request->eventGenre;
        foreach ($genres as $genre) {
            Genre::firstOrCreate(['genre' => $genre]);
        }

        $newSync = Genre::all()->whereIn('genre', $genres);

        $event->genres()->sync($newSync);

        return response($newSync);

    }

     // ------------------------------------------------------


    public function createExpect(Event $event)
    {
        $pivots = $event->contactLevels()->get();
        $contactLevels = ContactLevel::all();

        return view('events.create.Create_Expectations', compact('event','contactLevels','pivots'));
    }

    public function updateExpect(Request $request, Event $event)
    {
        $event->update(request()->validate([
            'contentAdvisories' => 'required',
            'mobilityAdvisories' => 'required',
            'sexualViolence' => 'required',
            'sexualViolenceDescription' => '',
            'touchAdvisoryDescription' => 'required',
            'wheelchairReady' => 'required',
        ]));

        $event->contactlevels()->sync(request('contactLevel'));



    }

    // ------------------------------------------------------


    public function createTitle(Event $event)
    {
        return view('events.create.Create_Title', compact('event'));
    }
    public function updateTitle(Request $request, Event $event)
    {
        $event->update(request()->validate([
            'eventTitle' => 'required',
        ]) + ['slug'=> str_slug(request('eventTitle'))]);
        return redirect('/create-your-event/'.$event->slug.'/images')->with(compact('event'));
    }

     // ------------------------------------------------------


    public function createImages(Event $event)
    {
        return view('events.create.Create_Image', compact('event'));
    }
    public function storeImages(Request $request, Event $event)
    {
        if ($request->hasFile('eventImage')) {
            $filename = $this->eventImageName($request, $event);

            $request->file('eventImage')->storeAs('/public/event-images', $filename);
                $large = storage_path().'/app/public/event-images/'.$filename;
                $small = storage_path().'/app/public/thumb-images/'.'thumb'.'-'.$filename;
                Image::make($large)->fit(1200, 800)->save($large)->fit(600, 400)->save($small);

                $event->update([
                    'eventImagePath' => 'event-images/' . $filename,
                    'thumbImagePath' => 'thumb-images/'.'thumb'.'-'.$filename,
                ]);
            return redirect('/create-your-event/'.$event->slug.'/thanks')->with(compact('event'));
        } else {
            return back()->withErrors(['Alert', 'No file selected!']);
        }
    }

    // ------------------------------------------------------


    public function thanks(Event $event)
    {
        return view('events.create.thanksCreate', compact('event'));
    }



     public function eventImageName($request, $event)
    {
        $title = $event->slug;
        $extension = $request->file('eventImage')->getClientOriginalExtension();
        $fileNameToStore= $title.'.'.$extension;
        return $fileNameToStore;
    }

}
