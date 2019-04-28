@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container" id="createContentArea">
    <create-description :event="{{$event}}" :genres="{{$genres}}" :pivots="{{$pivots}}">
</div>
@endsection