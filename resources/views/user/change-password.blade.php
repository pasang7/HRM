@extends('layouts.layout')
@section('title')
    Change Password
@endsection
@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Change Password</h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="newHrFormGrp bg-lgrey p-3">
                        <form method="POST" action="{{ route('user.change.password') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 form-group">
                                    <label for="cpassword">{{ __('Current Password') }}</label>
                                    <input id="cpassword" type="password"
                                        class="form-control{{ $errors->has('cpassword') ? ' is-invalid' : '' }}"
                                        name="cpassword" required>

                                    @if ($errors->has('cpassword'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('cpassword') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label>{{ __('New Password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
