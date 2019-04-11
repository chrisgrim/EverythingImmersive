
@extends('layouts.master')

@section('content')

<div>
	<div class="top-edit-create-event">
		<div>
			<h1>Welcome Back</h1>
		</div>
		<div>
			<form method="POST" action="/events" class="floating-form">
			@csrf
			    <button class="create"> New Event </button>
			</form>
		</div>
	</div>

	@foreach($events as $event)
		<div class="edit-create-grid">
			<div class="edit-create-image">
				@if ($event->eventImagePath !== null)
					<div class="grid-background-image" style="background-image: url('/storage/{{ $event->thumbImagePath }}');">
					</div>
				@else
					<div class="grid-background-image" style="background-color: grey">
						<p>Image Here soon</p>
					</div>
				@endif
			</div>
			<div class="edit-create-text">
				<div class="edit-create-text-title">
					<h2>{{ $event->eventTitle }}</h2>
				</div>
				<div>
					<p> You are almost done with editing your event!</p>
				</div>
				<div>
					<a href="/create-your-event/{{$event->slug}}/location">
					<button class="create"> Continue </button>
					</a>
				</div>
			</div>
			<div class="edit-create-delete">
				<a href="#open-event-modal-{{$event->slug}}">
					<div>
						<button id="hover" class="spin circle"><input class="trash-button" type="image" src="/storage/website-files/delete-button.png"></button>
					</div>
				</a>
			</div>
			<div id="open-event-modal-{{$event->slug}}" class="modal-window">
				<div class="modal-box">
					<div class="modal-top">
						<a href="#modal-close" title="Close" class="modal-close">Close</a>
						<div>
							<h3>Are you Sure you want to delete?</h3>
						</div>
						<div>
							<form action="/events/{{ $event->slug }}" method="POST">
							@method('DELETE')
							@csrf
							<input type="image" src="/storage/website-files/delete-button.png" style="width:30px">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach


</div>



   

@endsection
