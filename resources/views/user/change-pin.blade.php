@extends('layouts.layout')
@section('title')
    Change PIN
@endsection
@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Change PIN</h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="newHrFormGrp bg-lgrey p-3">
                        <form method="POST" action="{{ route('user.change.pin') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 form-group">
                                    <label for="cpassword">{{ __('Current PIN') }}</label>
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
                                    <label for="password">{{ __('New Pin') }}</label>
                                    <input id="pin" type="number"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="pin"
                                        required>

                                    @if ($errors->has('pin'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('pin') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm">
                                        {{ __('Reset Pin') }}
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
