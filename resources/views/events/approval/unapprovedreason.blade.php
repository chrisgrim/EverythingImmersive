@extends('layouts.master')

@section('content')
	<div class="index-container unapproved">
		<h2>Enter Reason for not approving Event</h2>
		
		<form method="POST" action="/approve-events/events/sendunapproved/{{$event->slug}}" class="floating-form">
        @csrf
        <div class="floating-label area">
            <textarea name="body" id="body" class="floating-input area" rows="8" value="{{ old('body')}}" placeholder=" " required autofocus></textarea>
            <label class="area"> Let them know why it wasn't approved </label>
            <input name="email" value="{{ $event->user->email }}" hidden>
        </div>
        <div class="">
            <button type="submit" class="slider slidein">
                <div class="circle">
                    <span class="icon arrow"></span>
                </div>
                <p class="button-text">Submit</p>
            </button>
       	</form>

	</div>
@endsection