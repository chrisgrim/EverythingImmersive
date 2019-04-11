@extends('layouts.master')

@section('content')
<div class="create-background" style="background-image: url('/storage/website-files/create-background.jpg">
	<div class="create-front-section">
		<div class="create-front-section-title">
			<h1>Share your event on <br> Everything Immersive</h1>
		</div>
		<div>
			<p>Get your event in front of the people who love experiences.</p>
		</div>
		<div>
			<form method="POST" action="/events" class="floating-form">
	        @csrf
	            <button type="submit" class="create">
	                Create
	            </button>
	    	</form>
		</div>
	</div>
</div>

   

@endsection
