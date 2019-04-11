@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container">
    <div>
    	<h2> Add a cover image</h2>
    </div>
    <div>
    	<p>Choose an image that best shows off your event</p>
    </div>
    <div id="app">
        {{-- <div>
            <featured-image :event="{{ $event }}"></featured-image>
        </div> --}}
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
            <button type="submit" class="create"> Save and Continue </button>
        </div>
    </form>
</div>
@endsection