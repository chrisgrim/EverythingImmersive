<!-- Desktop Menu Section -->
	<div class="desktop-menu-item link" style="float:left">
		<form action="/search">
			<input type="text" placeholder="Search City" name="search">
		</form>
	</div>
	{{-- <div class="desktop-menu-item link">
	<autocomplete :items="{{$eventsAll}}"></autocomplete>
	</div> --}}

@guest

	<div class="desktop-menu-item link">
		<a href="{{ route('login') }}">{{ __('Login') }}</a>
	</div>
	<div class="desktop-menu-item link">
		<a href="{{ route('register') }}">{{ __('Register') }}</a>
	</div>
	<div class="desktop-menu-item link">
		<a href="{{ url('/contact') }}">Contact Us</a>
	</div>
	<div class="desktop-menu-item link">
		<a href="{{ url('/events/create') }}">Host an Event</a>
	</div>



@else

	<div class="desktop-menu-item link">
		<a href="{{ url('/contact') }}">Contact Us</a>
	</div>
@if( $eventsAll->contains('user_id', auth()->id()) ) 
	<div class="desktop-menu-item link">
		<a href="{{ url('/create-your-event/edit') }}">Your Events</a>
	</div>
@else 
	<div class="desktop-menu-item link">
		<a href="{{ url('/events/create') }}">Add An Event</a>
	</div>
@endif
@if (Auth::user()->Admin())
	<div class="desktop-menu-item link">
		<a href="{{ url('/approve-events/events') }}">Approve Events</a>
	</div>
@endif
<div class="desktop-menu-item link dropdown-label">
		<profile-button :user="{{ auth()->user() }}" v-cloak></profile-button>
</div>

@endguest

<!-- Mobile Menu Section -->