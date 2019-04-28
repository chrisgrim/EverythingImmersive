@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container" id="createContentArea">
    <create-location :regions="{{$regions}}" :event="{{$event}}" :pivots="{{$pivots}}" />
</div>
@endsection