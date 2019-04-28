@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container" id="createContentArea">
    <create-expect :event="{{$event}}" :contact="{{$contactLevels}}" :pivots="{{$pivots}}">
    }
</div>
@endsection