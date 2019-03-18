@extends('events.createWalkthrough')
@section('createGuide')
<div>
	<h2> Add some Images</h2>
</div>
<div>
	<p>Choose an image that best shows off your event</p>
</div>
<div>
@include ('layouts.error')
<form method="POST" action="/create-your-event/{{$event->slug}}/images" class="floating-form" enctype="multipart/form-data">
	@method('PATCH')
    @csrf
    <div>
        <input type="file" name="eventImage" accept="image/*">
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