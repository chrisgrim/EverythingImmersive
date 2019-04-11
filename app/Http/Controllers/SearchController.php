<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
    	$search = request('search');
    	$events = Event::where('eventCity','LIKE', '%'.$search.'%' )->where('approved', true)->paginate(10);
    	

        return view('events.search',compact('events', 'search'));
    }
}
