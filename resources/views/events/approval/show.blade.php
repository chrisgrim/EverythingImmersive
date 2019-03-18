@extends('layouts.master')
@section('content')
	<div class="index-container unapproved">
		<div>
			<form action="/approve-events/events/{{ $event->slug }}" method="POST">
				@csrf
				@method('PATCH')
			<button>Approve</button>
			</form>
			<a href="/approve-events/events/unapproved/{{ $event->slug }}">
			<button> Unapprove</button>
			</a>
		</div>

		<div class="event-container">
			<div class="event-background-image" style="background-image: url('/storage/{{ $event->eventImagePath }}');">
				<div>
				</div>
			</div>

			<div class="event-details">
				<div class="event-details-section">
					<div class="event-category">
						<p> {{ $category->categoryName}}</p>
					</div>
					<div class="event-title">
						<h2>{{ $event->eventTitle }}</h2>
					</div>
					<div class="event-city">
						<a href="/cities/{{ str_slug($event->eventCity) }}">
							<h3>{{ $event->eventCity }}</h3>
						</a>
					</div>
				</div>

				<div class="event-details-section">
					<div class="event-description">
						<h3>What to expect with the immersive event</h3>
					</div>
					<div class="event-description-body">
						<p> {{ $event->eventDescription}}</p>
					</div>
				</div>
				<div class="event-details-section organizer">
					<div class="event-description-body">
						<h3>About {{ $organizer->organizationName }}</h3>
						<p> {{ $organizer->organizationDescription}}</p>
					</div>
					<div class="organizer-description box1">
						<img src="/storage/WebsiteFiles/logo.png">
					</div>
				</div>

				<div class="event-details-section">
					<div class="event-description">
						<h3>Imemrsive Event Location</h3>
					</div>
					<div class="event-location-street">
						<p> {{ $event->eventStreetNumber}}{{ $event->eventStreetAddress}}</p>
						<p> {{ $event->eventCity}} {{ $event->eventState}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="similar-events">
		<div id="grid-section">
			@foreach ($similarEvents as $similarEvent)
				<a href="/events/{{ $similarEvent->slug }}">
					<div class="event-grid">
						<div class="event-image">
							<div class="grid-background-image" style="background-image: url('/storage/{{ $similarEvent->thumbImagePath }}');">
								<div>
								</div>
							</div>
						</div>
						{{ $similarEvent->eventTitle }}
					</div>
				</a>
			@endforeach
		</div>
	</div>


	<div class="event-tickets">
		<a href="{{ $event->eventTicketUrl }}">
			<div class="event-ticket-button">
				<button>Buy Tickets</button>
			</div>
		</a>
			<div class="event-price">
				${{ $event->eventPrice }} per person
			</div>
		</div>
@endsection