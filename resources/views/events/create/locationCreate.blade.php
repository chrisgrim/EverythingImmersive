@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container">
    <div>
    	<h2> Location</h2>
    </div>
    <div>
    	<p>What city will your even happen in?</p>
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
            <button type="submit" class="slider slidein">
                <div class="circle">
                    <span class="icon arrow"></span>
                </div>
                <p class="button-text">Next</p>
            </button>
        </div>
    </form>
</div>
@endsection