@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container" id="createContentArea" >
    <create-details :event="{{$event}}">
</div>
@endsection