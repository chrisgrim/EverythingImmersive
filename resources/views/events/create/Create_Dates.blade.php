@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container">
    <div>
    	<h2> Event Dates</h2>
    </div>
    <div>
    <div id="createContentArea">
            <create-date-picker :event="{{$event}}"></create-date-picker>
    </div>
</div>
@endsection