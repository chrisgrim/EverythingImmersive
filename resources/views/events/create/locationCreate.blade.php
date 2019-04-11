@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container">
    <div class="create-front-section-title">
            <h1>Congratulations! You have just started creating an Event</h1>
    </div>
    <div>
        <p>You can edit this event anytime you like by clicking on Your Events.</p>
        <br>
        <br>
    </div>
    <div>
    	<p>Lets start with Location. What city will your event happen in?</p>
    </div>
    <div>
    @include ('layouts.error')
    <form method="POST" action="/create-your-event/{{$event->slug}}/location" class="floating-form">
    	@method('PATCH')
        @csrf
        <div class="floating-label">
            <input id="eventCity" type="text" class="floating-input" name="eventCity" value="{{ $event->eventCity}}" placeholder=" " required>
            <label>City</label>
        </div>
        <div class="">
            <button type="submit" class="create"> Next </button>
        </div>
    </form>
</div>
@endsection