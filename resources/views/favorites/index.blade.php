@extends('layouts.master')

@section('content')
	<div class="index-container">
		<h2>Explore Differnet Types of Immersive Events</h2>

		<h2>Our Latest Events</h2>
		<div id="app">
			<div id="grid-section">
				@foreach ($favorites->pluck('favorited') as $event)
					@include('events.grid')
				@endforeach
			</div>
		</div>
	</div>
@endsection