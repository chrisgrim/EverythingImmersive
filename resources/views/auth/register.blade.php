@extends('layouts.master')

@section('content')
<div class="form-container">
    <h2>{{ __('Register') }}</h2>
    <form method="POST" action="{{ route('register') }}" class="floating-form">
        @csrf

        <div class="floating-label"> 
            <input id="name" type="text" class="floating-input {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder=" " required autofocus>
            <label for="name">{{ __('Name') }}</label>
            
            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="floating-label">
            <input id="email" type="email" class="floating-input {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder=" " required>
            <label for="email" class="">{{ __('E-Mail Address') }}</label>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    
         <div class="floating-label">
            <input id="password" type="password" class="floating-input {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder=" " required>
            <label for="password" class="">{{ __('Password') }}</label>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="floating-label">
            <input id="password-confirm" class="floating-input" type="password" name="password_confirmation" placeholder=" " required>
            <label for="password-confirm"> {{ __('Confirm Password') }}</label>
        </div>

        <div class="">
            <button type="submit" class="slider slidein">
                <div class="circle">
                    <span class="icon arrow"></span>
                </div>
                <p class="button-text">{{ __('Register') }}</p>
            </button>
        </div>
    </form>
</div>
@endsection
