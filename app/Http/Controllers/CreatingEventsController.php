<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
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
    	return view('events.create.locationCreate', compact('event'));
    }

    public function updateLocation(Request $request, Event $event)
    {
    	$event->update(request()->validate([
    		'eventCity' => 'required'
    	]));
    	return redirect('/create-your-event/'.$event->slug.'/category')->with(compact('event'));
    }

		// ------------------------------------------------------


    public function createCategory(Event $event)
    {
        $categories = Category::latest()->get();
        $event->load('category');
    	return view('events.create.categoryCreate', compact('event', 'categories'));
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
    	return view('events.create.organizerCreate', compact('event', 'organizers'));
    }
    public function storeOrganizer(Request $request, Event $event, Organizer $organizer)
    {

    	$organizer = organizer::firstOrCreate(request()->validate([
    		'organizationName' => 'required',
    		'organizationDescription' => 'required',
    	]) + ['slug'=> str_slug(request('organizationName'))]);

    	$event->update(['organizer_id' => $organizer->id]);
    	
    }
     // ------------------------------------------------------


    public function createDescription(Event $event)
    {
        return view('events.create.descriptionCreate', compact('event'));
    }
    public function updateDescription(Request $request, Event $event)
    {
        $event->update(request()->validate([
            'eventDescription' => 'required',
            'eventPrice' => 'required',
            'eventWebsite' => 'required',
            'eventTicketUrl' => 'required'
        ]));
        return redirect('/create-your-event/'.$event->slug.'/expect')->with(compact('event'));
    }

     // ------------------------------------------------------


    public function createExpect(Event $event)
    {
        return view('events.create.expectCreate', compact('event'));
    }
    public function updateExpect(Request $request, Event $event)
    {
        $event->update(request()->validate([
            'eventExpectations' => 'required',
            'immersiveScore' => 'required|integer|between:1,10'

        ]));
        return redirect('/create-your-event/'.$event->slug.'/title')->with(compact('event'));
    }

    // ------------------------------------------------------


    public function createTitle(Event $event)
    {
        return view('events.create.titleCreate', compact('event'));
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
        return view('events.create.imageCreate', compact('event'));
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
