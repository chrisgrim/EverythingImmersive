<!-- Desktop Logo -->
<div class="desktop-logo">
	<a href="/"><img src="/storage/website-files/imm-logo.png"></a>
</div>

<!-- Mobile Logo -->


<div class="header mobile-logo">
	<input class="menu-btn" type="checkbox" id="menu-btn"/>
	<label class="menu-icon" for="menu-btn">
	  	<img src="/storage/website-files/logo.png">
		<div class="down-arrow">
			<div class="down-arrow-rotate">
				<svg viewBox="0 0 18 18" role="presentation" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="m16.29 4.3a1 1 0 1 1 1.41 1.42l-8 8a1 1 0 0 1 -1.41 0l-8-8a1 1 0 1 1 1.41-1.42l7.29 7.29z"></path></svg>
			</div>
		</div>
	</label>
	<ul class="menu">
		<li class="link"><a href="/">Home</a></li>
		@guest
		<li class="link"><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
		<li class="link"><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
		@else
		<li class="link"><a href="{{ route('logout') }}"
			onclick="event.preventDefault();
			document.getElementById('logout-form').submit();">
			{{ __('Logout') }}
			</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				@csrf
			</form>
		<
		@endguest
		<li class="link"><a href="{{ url('/contact') }}">Contact Us</a></li>
	</ul>
</div>


