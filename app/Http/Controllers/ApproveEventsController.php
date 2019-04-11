<?php

namespace App\Http\Controllers;

use App\Event;
use App\Category;
use App\Organizer;
use Mail;
use Illuminate\Http\Request;

class ApproveEventsController extends Controller
{
    public function __construct(Event $event)
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::get()->filter(function($event){
            return $event->isCompleted();
        })->where('approved', NULL);

        return view('events.approval.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Event $event)
    {  
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('events.approval.show', [
            'event' => $event,
            'category' => Category::find($event->category_id),
            'organizer' => Organizer::find($event->organizer_id),
            'similarEvents' => Event::SimilarCity($event)->UniqueCity($event)->inRandomOrder()->limit(3)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $event->update([
            'approved' => true,
        ]);
        return redirect('/approve-events/events');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
    public function unapprovedReason(Event $event)
    {
        return view('events.approval.unapprovedreason', compact('event'));
    }
    public function sendUnApproved(Request $request, Event $event)
    {
        // Takes the submited variables and puts them into the Database

        // Assigns the submitted variable names to variables in the controller
        $email = request('email');
        $content = request('body');

        // Uses the mail app to send the users info and email to whoever is specified below
         Mail::send('events.approval.emailApprovalForm', ['email' => $email, 'content' => $content], function ($message)
        {
            $message->from( 'chgrim@gmail.com', 'Site Name');
            $message->to(request('email'));
        });
        $event->update([
            'approved' => false,
        ]);

         // returns the user back to the page with success
         return redirect('/approve-events/events')->with('success','Your email was sent successfully!');
    }
}
