@extends ('layouts.master')

@section ('head')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section ('content')
<div class="form-container">
    <h2> Contact Us</h2>
    @include ('layouts.error')
    <form method="POST" action="{{ route('store_contact') }}" class="floating-form">
        @csrf
        <div class="floating-label area">
            <textarea name="body" id="body" class="floating-input area" rows="8" value="{{ old('body')}}" placeholder=" " required autofocus></textarea>
            <label class="area"> Message Us </label>
        </div>
        <div class="floating-label">
            <input id="email" type="email" class="floating-input" name="email" value="{{ old('email') }}" placeholder=" " required>
            <label>Email</label>
        </div>
        <div>
            <div class="g-recaptcha" data-sitekey="6LfXCGkUAAAAANuj8BdiyUDsiTFfyy3Rn8o0L7PJ"></div>
        </div>
        <div class="">
            <button type="submit" class="slider slidein">
                <div class="circle">
                    <span class="icon arrow"></span>
                </div>
                <p class="button-text">Submit</p>
            </button>
        </div>
    </form>
</div>
@endsection ('content')