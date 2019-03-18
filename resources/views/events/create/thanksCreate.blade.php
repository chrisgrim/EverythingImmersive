@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container">
    <div>
    	<h2> Thanks for creating your event {{ $event->eventTitle }} on {{config('app.name')}}</h2>
    </div>
    <div>
    	<img src='/storage/{{ $event->thumbImagePath }}' alt="{{ $event->slug }}">
    </div>
    <div>
    	<p>Events are normally approved in 2-3 business days</p>
    </div>
    <div>
</div>
@endsection