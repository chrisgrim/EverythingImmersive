@extends('layouts.master')

@section('content')
<div>
	@foreach($userlist as $user)
		<div>
			{{$user->name}}
		</div>
	@endforeach
</div>
<div>
	{{ $userlist->links() }}
</div>
   

@endsection
