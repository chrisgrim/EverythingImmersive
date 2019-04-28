@extends('layouts.master')

@section('content')
<div id="create-event-container">
<guide>
	@include('events.create.Create_Guide')
</guide>
<form-section>
	@yield('createGuide')
</form-section>
</div>

   

@endsection