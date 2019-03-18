@extends('layouts.master')
@section('content')
<div class="index-container">
<div>
	<h2> {{ $category->categoryName }} </h2>
</div>

<div id="grid-section">
@foreach ($category->events as $event)
	<a href="/events/{{ $event->slug }}">
	<div class="event-grid">
		<div class="event-image">
			<div class="grid-background-image" style="background-image: url('/storage/{{ $event->thumbImagePath }}');">
				<div>
				</div>
			</div>
		</div>
		{{ $event->eventTitle }}
	</div>
	</a>
@endforeach
</div>
</div>

@endsection