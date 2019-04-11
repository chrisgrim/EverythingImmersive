<div class="guide-container">

<a href="/create-your-event/{{$event->slug}}/location">
<div class="guide-section">
	location 
	@if ($event->eventCity !== null)
    	<svg viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
	@endif
</div>
</a>

<a href="/create-your-event/{{$event->slug}}/category">
<div class="guide-section">
	Category
	@if( $event->category_id !== null )
	<svg viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
	@endif
</div>
</a>

<a href="/create-your-event/{{$event->slug}}/organizer">
<div class="guide-section">
	Who is Putting it On?
	@if ($event->organizer_id !== null)
	<svg viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
	@endif
</div>
</a>


<a href="/create-your-event/{{$event->slug}}/description">
<div class="guide-section">
	Event Description
	@if ($event->eventDescription !== null)
	<svg viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
	@endif
</div>
</a>

<a href="/create-your-event/{{$event->slug}}/expect">
<div class="guide-section">
	What Guests should expect
	@if ($event->eventExpectations !== null)
	<svg viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
	@endif
</div>
</a>

<a href="/create-your-event/{{$event->slug}}/title">
<div class="guide-section">
	Title
	@if ($event->eventTitle !== null)
	<svg viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
	@endif
</div>
</a>

<a href="/create-your-event/{{$event->slug}}/images">
<div class="guide-section">
	Photos
	@if ($event->eventImagePath !== null)
	<svg viewBox="0 0 42 42" fill="currentColor" fill-opacity="0" stroke="#008489" stroke-width="3" focusable="false" role="presentation" stroke-linecap="round" stroke-linejoin="round" style="height: 1.5em; width: 1.5em; display: block; overflow: visible;float:right;"><path d="m19.1 25.2 4.7 6.2 12.1-11.2"></path></svg>
	@endif
</div>
</a>

</div>