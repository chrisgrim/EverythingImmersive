<?php

namespace App\Http\Controllers;

use Mail;
use App\Contact;
use App\Http\Requests\ContactUsRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactUsRequest $request)
    {
        // Takes the submited variables and puts them into the Database
        Contact::create([
            'email' => request('email'),
            'body' => request('body'),
        ]);

        // Assigns the submitted variable names to variables in the controller
        $email = request('email');
        $content = request('body');

        // Uses the mail app to send the users info and email to whoever is specified below
         Mail::send('contact.emailform', ['email' => $email, 'content' => $content], function ($message)
        {
            $message->from( 'chgrim@gmail.com', 'Site Name');
            $message->to('chgrim@gmail.com');
        });

         // returns the user back to the page with success
         return back()->with('success','Your email was sent successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
