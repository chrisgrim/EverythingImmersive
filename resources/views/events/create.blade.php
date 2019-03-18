@extends('layouts.master')

@section('content')

Its time to create your own event!

<form method="POST" action="/events" class="floating-form">
        @csrf
            <button type="submit" class="slider slidein">
                <div class="circle">
                    <span class="icon arrow"></span>
                </div>
                <p class="button-text">Create</p>
            </button>
    </form>

   

@endsection
