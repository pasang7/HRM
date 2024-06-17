@extends('layouts.layout')
@section('title', 'Create Designation')

@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Update Designation</h5>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="newHrFormGrp bg-lgrey p-3">
                        <form class="fw-600" autocomplete="off" method="POST"
                            action="{{ route('designation.update', $designation->id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for="name" class="required ">Name</label>
                                    <input id="name" type="text" class="form-control custom-form-control" name="name"
                                        placeholder="Department Name" value="{{ $designation->name }}" autofocus="">
                                    @if ($errors->has('name'))
                                        <div class="text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="name" class="required ">Status</label>
                                    <select class="form-control custom-form-control" id="is_active" name="is_active"
                                        required>
                                        <option value="yes"
                                            {{ old('is_active', isset($designation->is_active) ? $designation->is_active : '') == 'yes'? 'selected="selected"': '' }}>
                                            Active</option>
                                        <option value="no"
                                            {{ old('is_active', isset($designation->is_active) ? $designation->is_active : '') == 'no'? 'selected="selected"': '' }}>
                                            Inactive</option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm">Update Now</button>
                                </div>


                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugin/timepicker/timepicker.min.css') }}" />
    <style type="text/css">
        .required:after {
            content: " *";
            color: red;
        }

    </style>
@endsection
