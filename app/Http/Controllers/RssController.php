<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;


class RssController extends Controller
{
    public function index(Event $event)
    {
    	$event->load('category','organizer','user');
    	$genres = $event->genres()->get();
    	$regions = $event->regions()->get();
    	$contactLevels = $event->contactlevels()->get();

    	return view('RSS.index', compact('event','genres','regions','contactLevels'));
    }
}
