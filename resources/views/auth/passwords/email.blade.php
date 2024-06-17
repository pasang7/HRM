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
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class=" row">
                                <div class="col-lg-12 text-center ">
                                    <h5 class="text-dark font-weight-bold">Reset Password</h5>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <label for="email"
                                    >{{ __('E-Mail Address') }}</label>


                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mt-4">
                                    <button type="submit"
                                            style="--main_header_color : {{ $settings->main_header_color }};"
                                            class="btn btn-primary w-100">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
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
