@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container">
    <div class="create-guide-title">
    	<h2> Who is Hosting this event?</h2>
    </div>
    <div>
    	<p>Let us know about your organization</p>

    </div>
    <div>
    @include ('layouts.error')
    
        <div id="orgAutoComplete">
            <organizationAutocomplete :items="{{$organizers}}" :event="{{$event}}" />
            </organizationAutocomplete>
        </div>

</div>

@endsection