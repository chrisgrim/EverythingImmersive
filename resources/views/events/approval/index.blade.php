@extends('layouts.master')

@section('content')
	<div class="index-container unapproved">
		<h2>Events that need to be approved</h2>
		<div id="grid-section">
			@foreach ($events as $event)
				@include('events.approval.grid')
			@endforeach
		</div>
	</div>
@endsection
