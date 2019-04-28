@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container">
    <div>
    	<h2> What is the Title of your Event?</h2>
    </div>
    <div>
    	<p>Make it a good one!</p>
    </div>
    <div>
    @include ('layouts.error')
    <form method="POST" action="/create-your-event/{{$event->slug}}/title" class="floating-form">
    	@method('PATCH')
        @csrf
        <div class="floating-label">
            <input id="eventTitle" type="text" class="floating-input" name="eventTitle" value="{{ $event->eventTitle}}" placeholder=" " required>
            <label>Event Title</label>
        </div>
        <div class="">
            <button type="submit" class="create"> Save and Continue </button>
        </div>
    </form>
</div>
@endsection