@extends('layouts.layout')
@section('title','Create Department')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-8 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header header-bg" style="--sec_header_color: {{ $settings->sec_header_color }};"><p class="mb-0 fw-600 card-title">Create Department</p></div>

                    <div class="card-body bg-lgrey">
                            <form class="fw-600" autocomplete="off" method="POST" action="{{ route('department.store') }}">
                                @csrf
                                <div class="row form-group">
                                    <label for="name" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 col-form-label required text-md-right">Name</label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input id="name" type="text" class="form-control custom-form-control" name="name" placeholder="Department Name" value="" required="" autofocus="">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label for="post" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 col-form-label text-md-right required">Shift</label>

                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 here">
                                        <div class="form-group row shift" id="shift1">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shift-name">
                                                Shift 1
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-5">
                                                <input type="text" class="form-control custom-form-control time start ui-timepicker-input" name="clockin[]" placeholder="From" required="" autocomplete="off">
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-5">
                                                <input type="text" class="form-control custom-form-control time end ui-timepicker-input" name="clockout[]" placeholder="To" required="" autocomplete="off">
                                            </div>
                                            {{-- @if(1==2) --}}
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-2">
                                                <button style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm add_shift" type="button"><i class="fa fa-plus"></i></button>
                                            </div>
                                            {{-- @endif --}}
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label for="post" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 col-form-label text-md-right required">Holiday</label>

                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <div class="form-group">
                                            <input type="checkbox" name="holiday[]" value="0"> <span>Sunday</span><br>
                                            <input type="checkbox" name="holiday[]" value="1"> <span>Monday</span><br>
                                            <input type="checkbox" name="holiday[]" value="2"> <span>Tuesday</span><br>
                                            <input type="checkbox" name="holiday[]" value="3"> <span>Wednesday</span><br>
                                            <input type="checkbox" name="holiday[]" value="4"> <span>Thursday</span><br>
                                            <input type="checkbox" name="holiday[]" value="5"> <span>Friday</span><br>
                                            <input type="checkbox" name="holiday[]" value="6"> <sapn>Saturday</sapn><br>
                                        </div>

                                    </div>
                                </div>
                                <div class="btn-create-wrapper">
                                    <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm btn-create">Create</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/plugin/timepicker/timepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugin/timepicker/datepair.js')}}"></script>
    <script>
        var count=1

        $(window).ready(function(){
            $('.time').timepicker({
                'minTime': '1',
                'showDuration': true,

                'timeFormat': 'g:ia',
                'disableTextInput':true,
                'default': false
            });
            var a = document.getElementById('shift1');
            var b = new Datepair(a);
        })
        $(document).on('click','.add_shift',function(){
            count++;
            shift= 'shift'+count;
            var shift_html='<div class="form-group row shift" id="'+shift+'"> <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shift-name">Shift '+count+ ' </div><div class="col-lg-5 col-md-5 col-sm-5 col-5"><input type="text" class="form-control custom-form-control time start" name="clockin[]" required></div><div class="col-lg-5 col-md-5 col-sm-5 col-5"><input type="text" class="form-control custom-form-control time end" name="clockout[]" required></div><div class="col-lg-2 col-md-2 col-sm-2 col-2"><button class="btn btn-danger remove_shift" type="button"><i class="fa fa-minus"></i></button></div></div>'
            $('.here').append(shift_html);

            $('.time').timepicker({
                'minTime': '1',
                'showDuration': true,
                'timeFormat': 'g:ia',
                'disableTextInput':true,
                'default': false
            });
            var a = document.getElementById(shift);
            var b = new Datepair(a);
        })

    </script>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugin/timepicker/timepicker.min.css') }}" />
<style type="text/css">
    .required:after {
        content:" *";
        color: red;
    }
</style>
@endsection
