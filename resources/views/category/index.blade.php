@extends('layouts.master')

@section('content')
	<div class="index-container">
		<h2>Explore Differnet Types of Immersive Events</h2>
		<div id="explore-grid-section">
			@foreach ($categories as $category)

			@endforeach
		</div>
	</div>
@endsection
