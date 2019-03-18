@extends('layouts.master')

@section('content')

            <div class="form-container">
                <h2>{{ __('Reset Password') }}</h2>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="floating-form">
                        @csrf

                        <div class="floating-label">
                            <input id="email" type="email" class="floating-input {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder=" " required>
                            <label for="email">{{ __('E-Mail Address') }}</label>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                       <button type="submit" class="slidein reset">
                            <div class="circle">
                                <span class="icon arrow"></span>
                            </div>
                            <p class="button-text">{{ __('Send Password Reset Link') }}</p>
                        </button> 
                    </form>
                </div>
            </div>

@endsection
