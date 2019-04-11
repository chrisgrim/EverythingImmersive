@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container">
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
        <div>
            <p>Give guests an idea of how interactive the event will be. (1 is no interaction with actors, 10 being full interaction with acting.)</p>
            <select name="immersiveScore" id="immersiveScore" class="form-control" required>
                @if( $event->immersiveScore == null )
                    <option value="" hidden>Choose Immersive Score</option>
                @endif
                @foreach (range(1, 10) as $item)
                    <option value="{{ $item }}" @if($item == $event->immersiveScore) selected @endif >{{ $item }}</option>
                @endforeach

            </select>
        </div>
        <div class="">
            <button type="submit" class="create"> Save and Continue </button>
        </div>
    </form>
</div>
@endsection