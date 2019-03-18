<?php

namespace App\Http\Controllers;

use App\Event;
use App\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
    public function store(Event $event)
    {
    	$event->favorites()->create(['user_id' => auth()->id()]);
		return back();
    }
    public function destroy(Event $event)
    {
    	// $event->unFavorite();
    	$event->MorphMany(Favorite::class, 'favorited')->where('user_id', auth()->id())->delete();

		return back();
    }
}
