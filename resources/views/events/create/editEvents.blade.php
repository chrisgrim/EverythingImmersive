
@extends('layouts.master')

@section('content')

<div>
	<div class="top-edit-create-event">
		<div>
			<h2>Welcome Back</h2>
		</div>
		<div>
			<form method="POST" action="/events" class="floating-form">
			@csrf
			    <button type="submit" class="slider slidein">
			        <div class="circle">
			            <span class="icon arrow"></span>
			        </div>
			        <p class="button-text">New Idea</p>
			    </button>
			</form>
		</div>
	</div>

	@foreach($events as $event)
		<div class="edit-create-grid">
			<div class="edit-create-image">
				<div class="grid-background-image" style="background-image: url('/storage/{{ $event->thumbImagePath }}');">
				</div>
			</div>
			<div class="edit-create-text">
				<div>
					<h3>{{ $event->eventTitle }}</h3>
				</div>
				<div>
					<p> You are almost done with editing your event!</p>
				</div>
				<div>
					<a href="/create-your-event/{{$event->slug}}/location">
					<button> Edit </button>
					</a>
				</div>
			</div>
			<div class="edit-create-delete">
				<form action="/events/{{ $event->slug }}" method="POST">
				@method('DELETE')
				@csrf
				<button> delete </button>
				</form>
			</div>		
		</div>
	@endforeach


</div>



   

@endsection
