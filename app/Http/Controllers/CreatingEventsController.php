<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateOrganizerRequest;
use App\Http\Requests\ValidateDescriptionRequest;
use App\Http\Requests\ValidateDetailsRequest;
use App\Http\Requests\ValidateExpectRequest;
use App\Http\Requests\ValidateLocationRequest;
use App\Http\Requests\ValidateCategoryRequest;
use App\Http\Requests\ValidateTitleRequest;
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

    public function updateLocation(ValidateLocationRequest $request, Event $event)
    {
    	$event->update($request->all());
        $event->regions()->sync(request('eventRegion'));


    }

		// ------------------------------------------------------

    public function createCategory(Event $event)
    {
        $categories = Category::latest()->get();
        $event->load('category');

    	return view('events.create.Create_Category', compact('event', 'categories'));
    }
    public function updateCategory(ValidateCategoryRequest $request, Event $event)
    {
    	$event->update(['category_id'=> request('id')]);
    }

    // ------------------------------------------------------

    public function createOrganizer(Event $event)
    {
        $event->load('organizer');
        $organizers = Organizer::all();
    	return view('events.create.Create_Organizer', compact('event', 'organizers'));
    }

    public function storeOrganizer(ValidateOrganizerRequest $request, Event $event, Organizer $organizer)
    {
        if (!$organizer = $organizer->updateOrCreate($request->all())) {
            return response()->json(['error' => 'Failed to save organizer'], 402);
        }

    	$event->update(['organizer_id' => $organizer->id]);
        return response()->json(compact('organizer'));
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

    public function updateDetails(ValidateDetailsRequest $request, Event $event)
    {
        $event->update(request()->all());
    }

     // ------------------------------------------------------

    public function createDescription(Event $event)
    {
        $pivots = $event->genres()->get();
        $genres = Genre::all();

        return view('events.create.Create_Description', compact('event','genres','pivots'));
    }

    public function updateDescription(ValidateDescriptionRequest $request, Event $event)
    {
        $event->updateDescription($request->all());
    }

     // ------------------------------------------------------


    public function createExpect(Event $event)
    {
        $pivots = $event->contactLevels()->get();
        $contactLevels = ContactLevel::all();

        return view('events.create.Create_Expectations', compact('event','contactLevels','pivots'));
    }

    public function updateExpect(ValidateExpectRequest $request, Event $event)
    {
        $event->update($request->all());
        $event->contactlevels()->sync(request('contactLevel'));
    }

    // ------------------------------------------------------

    public function createTitle(Event $event)
    {
        return view('events.create.Create_Title', compact('event'));
    }
    public function updateTitle(ValidateTitleRequest $request, Event $event)
    {
        $event->updateTitle($request);
        return response()->json(compact('event'));
    }

     // ------------------------------------------------------


    public function createImages(Event $event)
    {
        return view('events.create.Create_Image', compact('event'));
    }
    public function storeImages(Request $request, Event $event)
    {
        $event->storeEventImage($request);
    }

    // ------------------------------------------------------


    public function thanks(Event $event)
    {
        return view('events.create.thanksCreate', compact('event'));
    }

}
