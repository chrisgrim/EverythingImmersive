@extends('events.createWalkthrough')
@section('createGuide')
<div>
	<h2> What can your guests expect?</h2>
</div>
<div>
	<p>Let the guests know what they can expect. Will there be scary noises or bright flashes?</p>
</div>
<div>
@include ('layouts.error')
<form method="POST" action="/create-your-event/{{$event->slug}}/expect" class="floating-form">
	@method('PATCH')
    @csrf
    <div class="floating-label area">
        <textarea name="eventExpectations" id="eventExpectations" class="floating-input area" rows="8" placeholder=" " required autofocus>{{ $event->eventExpectations }}</textarea>
        <label class="area"> Let your guests know what to expect with the event/performance </label>
    </div>
    <div class="">
        <button type="submit" class="slider slidein">
            <div class="circle">
                <span class="icon arrow"></span>
            </div>
            <p class="button-text">Save and Continue</p>
        </button>
    </div>
</form>
@endsection