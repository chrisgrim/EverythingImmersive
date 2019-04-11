@extends('layouts.master')

@section('content')
	<div class="index-container">
		<h2>Explore Immersive Events in {{$search}}</h2>
		<div id="app">
			<div id="grid-section">
				@foreach ($events as $event)
					@include('events.grid')
				@endforeach
			</div>
		</div>
	</div>
@endsection
