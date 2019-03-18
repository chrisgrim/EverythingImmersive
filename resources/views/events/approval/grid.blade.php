<a href="/approve-events/events/{{ $event->slug }}">
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