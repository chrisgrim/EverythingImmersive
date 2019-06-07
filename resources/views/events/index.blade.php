@extends('layouts.master')

@section('content')
	<div class="index-container" id="createContentArea">
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
		{{-- <event-listing :events="{{$events}}"></event-listing> --}}
		<event-listing-two></event-listing-two>
	</div>
@endsection
