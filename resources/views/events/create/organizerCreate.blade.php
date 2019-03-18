@extends('events.createWalkthrough')
@section('createGuide')
<div>
	<h2> Describe Your Organization</h2>
</div>
<div>
	<p>Describe your business qualifications to guests</p>

</div>
<div>
@include ('layouts.error')
@if( $event->organizer_id !== null )
<form method="POST" action="/create-your-event/{{$event->slug}}/organizer" class="floating-form">
    @csrf
    <div class="floating-label">
        <input id="organizationName" type="text" class="floating-input" name="organizationName" value="{{ $event->organizer->organizationName }}" placeholder=" " required>
        <label>What is the Name of your company?</label>
    </div>
    <div class="floating-label area">
        <textarea name="organizationDescription" id="organizationDescription" class="floating-input area" rows="8" value="" placeholder=" " required autofocus>{{ $event->organizer->organizationDescription }}</textarea>
        <label class="area"> Let guests know a little about your company </label>
    </div>
    <div class="">
        <button type="submit" class="slider slidein">
            <div class="circle">
                <span class="icon arrow"></span>
            </div>
            <p class="button-text">Save and Continue</p>
        </button>
    </div>
</form>
@else
<form method="POST" action="/create-your-event/{{$event->slug}}/organizer" class="floating-form">
    @csrf
    <div class="floating-label">
        <input id="organizationName" type="text" class="floating-input" name="organizationName" value="" placeholder=" " required>
        <label>What is the Name of your company?</label>
    </div>
    <div class="floating-label area">
        <textarea name="organizationDescription" id="organizationDescription" class="floating-input area" rows="8" value="" placeholder=" " required autofocus></textarea>
        <label class="area"> Let guests know a little about your company </label>
    </div>
    <div class="">
        <button type="submit" class="slider slidein">
            <div class="circle">
                <span class="icon arrow"></span>
            </div>
            <p class="button-text">Save and Continue</p>
        </button>
    </div>
</form>
@endif
@endsection