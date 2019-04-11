@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container">
    <div>
    	<h2> Event Description</h2>
    </div>
    <div>
    	<p>What can your guests expect with the event?</p>
    </div>
    <div>
    @include ('layouts.error')
    <form method="POST" action="/create-your-event/{{$event->slug}}/description" class="floating-form">
    	@method('PATCH')
        @csrf
        <div class="floating-label area">
            <textarea name="eventDescription" id="eventDescription" class="floating-input area" rows="8" placeholder=" " required autofocus>{{ $event->eventDescription }}</textarea>
            <label class="area"> Let your guests know what to expect with the event/performance </label>
        </div>
        <div class="floating-label">
            <input id="eventWebsite" type="text" class="floating-input" name="eventWebsite" value="{{ $event->eventWebsite}}" placeholder=" " required>
            <label>Event Website</label>
        </div>
        <div class="floating-label">
            <input id="eventPrice" type="text" class="floating-input" name="eventPrice" value="{{ $event->eventPrice}}" placeholder=" " required>
            <label>Event Cost</label>
        </div>
        <div class="floating-label">
            <input id="eventTicketUrl" type="text" class="floating-input" name="eventTicketUrl" value="{{ $event->eventTicketUrl}}" placeholder=" " required>
            <label>Ticket URL (if different from Website url above)</label>
        </div>
        <div class="">
            <button type="submit" class="create"> Save and Continue </button>
        </div>
    </form>
</div>
@endsection