@extends('events.createWalkthrough')
@section('createGuide')
<div class="create-container">
    <div class="create-guide-title">
    	<h2> What type of Event are you hosting?</h2>
    </div>
    <div>
    	<p>Choose the category that best describes your event</p>
    </div>

    <div>
    @include ('layouts.error')
    <form method="POST" action="/create-your-event/{{ $event->slug }}/category" class="floating-form">
        @method('PATCH')
        @csrf
        <div>
            <select name="category_id" id="category_id" class="form-control" required>
                @if( $event->category_id == null )
                <option value="" hidden>Choose Catagory</option>
                @endif
                @foreach ($categories as $category)
                    <option value="{{ $category->id}}"
                        @if($category->id == $event->category_id) selected @endif >
                        {{ $category->categoryName}}</option>
                @endforeach
            </select>
        </div>

        <div class="">
            <button type="submit" class="create"> Save and Continue </button>
        </div>
    </form>
</div>
@endsection