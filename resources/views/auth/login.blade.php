@extends('layouts.master')

@section('content')
<div class="form-container">
    <h2>{{ __('Login') }}</h2>
    <form method="POST" action="{{ route('login') }}"" class="floating-form">
        @csrf
        <div class="floating-label">
            <input id="email" type="email" class="floating-input {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder=" ">
            <label class="float" for="email"> {{ __('E-Mail Address') }} </label>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="floating-label">
            <input id="password" type="password" class="floating-input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder=" ">
            <label for="password">{{ __('Password') }}</label>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="floating-label">
            <input class="floating-input checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>

        <div class="inline">
            <button type="submit" class="slider slidein">
                <div class="circle">
                    <span class="icon arrow"></span>
                </div>
                <p class="button-text">{{ __('Login') }}</p>
            </button>
            <div>
                <a href="/login/google">
                    Login with Google
                </a>
            </div>
            @if (Route::has('password.request'))
                <div class="link remember">
                    <a href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            @endif

        </div>

        
    </form>
</div>
@endsection
