@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container" id="createContentArea">
    <create-categories :event="{{$event}}" :categories="{{$categories}}"></create-categories>
</div>
@endsection