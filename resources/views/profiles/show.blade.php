@extends ('layouts.master')
@section ('content')
<div class="container">
	<div class="profile-sect-top">
	</div>
<div class="profile-sect-content">
	<div>
		<avatar-form :user="{{ $user }}"></avatar-form>
	</div>
	<div>
		<h2> {{$user->name}} </h2>
	</div>
	<div class="interior">
		<a class="btn btn-danger" href="#open-modal">Delete</a>
	</div>
	<div id="open-modal" class="modal-window">
		<div>
			<a href="#modal-close" title="Close" class="modal-close">Close</a>
			<h1>Are you sure?</h1>
			<div>
				<form action ="/user/{{$user->id}}" method="POST">
					@csrf
					{{ method_field('DELETE') }}
					<div class="form-group">
						<button type="submit" class="btn btn-link">Delete</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
</div>
@endsection ('content')