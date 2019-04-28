@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container">
    <div class="create-guide-title">
    	<h2> Who is Hosting this event?</h2>
    </div>
    <div>
    @include ('layouts.error')
    
        <div id="createContentArea">
            <create-organization :items="{{$organizers}}" :event="{{$event}}" />
        </div>

</div>

@endsection