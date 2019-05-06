@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container" id="createContentArea">
    <create-image :event="{{$event}}"></create-image>
</div>
@endsection