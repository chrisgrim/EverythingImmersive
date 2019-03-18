<!-- Desktop Menu Section -->
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

	@if( $events->contains('user_id', auth()->id()) ) 
		<div class="desktop-menu-item link">
			<a href="{{ url('/create-your-event/edit') }}">Your Events</a>
		</div>
	@else 
		<div class="desktop-menu-item link">
			<a href="{{ url('/events/create') }}">Add An Event</a>
		</div>
		<div class="desktop-menu-item link">
			<a href="/user/{{auth()->id()}}">Profile</a>
		</div>

	@endif

	@if (Auth::user()->Admin())
		<div class="desktop-menu-item link">
			<a href="{{ url('/approve-events/events') }}">Approve Events</a>
		</div>
	@endif

	<div class="desktop-menu-item link">
		<a href="{{ route('logout') }}"
			onclick="event.preventDefault();
			document.getElementById('logout-form').submit();">
			{{ __('Logout') }}
		</a>
		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				@csrf
		</form>
		</div>
@endguest

<!-- Mobile Menu Section -->