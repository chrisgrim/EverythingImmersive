<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;


class RssController extends Controller
{
    public function index(Event $event)
    {
    	return view('RSS.index', compact('event'));
    }
}
