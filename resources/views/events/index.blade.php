@extends('layouts.master')

@section('content')
	<div class="index-container">
		<h2>Explore Differnet Types of Immersive Events</h2>
		<div id="explore-grid-section">
			@foreach ($categories as $category)
				<a href="/categories/{{ $category->slug }}">

					<div class="explore-grid-container">
						<div class="explorer-background-image" style="background-image: url('/storage/{{ $category->categoryImagePath }}');">
							<div>
							</div>
						</div>
						<div>
							<h3>{{ $category->categoryName }}</h3>
						</div>
					</div>
				</a>
			@endforeach
		</div>

		<h2>Our Latest Events</h2>
		<div id="app">
			<div id="grid-section">
				@foreach ($events as $event)
					@include('events.grid')
				@endforeach
			</div>
		</div>
	</div>
@endsection
