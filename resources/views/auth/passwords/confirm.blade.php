@extends('layouts.guest')

@section('content')
    <div class="loginWrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="loginBg">
                        <div class="userIconLog">
                            <img src="{{ asset('theme/images/logo-small.png') }}" alt="">
                        </div>
                        {{ __('Please confirm your password before continuing.') }}

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class=" row">
                                <div class="col-lg-12">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mt-4">
                                    <button type="submit"
                                            style="--main_header_color : {{ $settings->main_header_color }};"
                                            class="btn btn-primary">
                                        {{ __('Confirm Password') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="poweredByLogo"><img src="{{ asset('theme/images/pocketLogo.png') }}" alt=""></div>
            </div>
        </div>
    </div>

@endsection
