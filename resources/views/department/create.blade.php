@extends('layouts.layout')
@section('title', 'Create Department')

@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Create Department</h5>
                    </div>
                </div>
                <div class="col-lg-12 mt-2">
                    <div class="newHrFormGrp  bg-lgrey">
                        <form class="fw-600" autocomplete="off" method="POST"
                            action="{{ route('department.store') }}">
                            @csrf
                            <div class="row form-group">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <label for="name" class=" col-form-label required text-md-right">Name</label>
                                    <input id="name" type="text" class="form-control custom-form-control" name="name"
                                        placeholder="Department Name" value="" required="" autofocus="">
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 here">
                                <label for="post" class="col-form-label text-md-right required">Select Shift</label>
                                <div class="mb-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <input type="text" class="form-control custom-form-control time start mr-3"
                                            name="clockin[]" placeholder="From" required="" autocomplete="off">
                                        <input type="text"
                                            class="form-control custom-form-control time end mr-3"
                                            name="clockout[]" placeholder="To" required="" autocomplete="off">
                                        <button style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary add_shift" type="button"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="form-group row ">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="post" class="col-form-label text-md-right required">Holiday</label>

                                    <div class="form-group">
                                        <div class="d-flex align-items-center">

                                            <input type="checkbox" class="mr-1" name="holiday[]" value="0">
                                            <span class="mr-3 checkLabel">Sunday</span><br>
                                            <input type="checkbox" class="mr-1" name="holiday[]" value="1">
                                            <span class="mr-3 checkLabel">Monday</span><br>
                                            <input type="checkbox" class="mr-1" name="holiday[]" value="2">
                                            <span class="mr-3 checkLabel">Tuesday</span><br>
                                            <input type="checkbox" class="mr-1" name="holiday[]" value="3">
                                            <span class="mr-3 checkLabel">Wednesday</span><br>
                                            <input type="checkbox" class="mr-1" name="holiday[]" value="4">
                                            <span class="mr-3 checkLabel">Thursday</span><br>
                                            <input type="checkbox" class="mr-1" name="holiday[]" value="5">
                                            <span class="mr-3 checkLabel">Friday</span><br>
                                            <input type="checkbox" class="mr-1" name="holiday[]" value="6">
                                            <span class="mr-3 checkLabel">Saturday</span><br>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="btn-create-wrapper">
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm btn-create"><i data-feather="check"></i>Create Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- <script type="text/javascript" src="{{ asset('assets/plugin/timepicker/timepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugin/timepicker/datepair.js') }}"></script> --}}
    <script>
        var count = 1

        $(window).ready(function() {
            // $('.time').timepicker({
            //     'minTime': '1',
            //     'showDuration': true,

            //     'timeFormat': 'g:ia',
            //     'disableTextInput': true,
            //     'default': false
            // });

            $('.time').chungTimePicker();

            var a = document.getElementById('shift1');
            // var b = new Datepair(a);
        })
        $(document).on('click', '.add_shift', function() {
            count++;
            shift = 'shift' + count;
            var shift_html = '<div class="col-lg-6 mb-3"><div class="d-flex align-items-center justify-content-between">'+
                '<input type = "text" class = "form-control custom-form-control time start mr-3" name = "clockin[]" placeholder = "From" required = "" autocomplete = "off" >'+
                '<input type = "text" class = "form-control custom-form-control time end mr-3" name = "clockout[]" placeholder = "To" required = "" autocomplete = "off">'+
                '<button class="btn btn-danger remove_shift" type="button"> <i class="fas fa-minus"></i></button></div></div>';
            $('.here').append(shift_html);
            // $('.time').timepicker({
            //     'minTime': '1',
            //     'showDuration': true,
            //     'timeFormat': 'g:ia',
            //     'disableTextInput': true,
            //     'default': false
            // });
            $('.time').chungTimePicker();
            var a = document.getElementById(shift);
            // var b = new Datepair(a);
        });
        $(document).on('click','.remove_shift',function(e){
        count--;
        this.parentNode.parentNode.remove();
        this_count=1;
        $('.shift').each(function(){
            $(this).find('.shift-name')[0].innerText='Shift '+this_count
            this_count++
            // console.log('Done')
        });
    });
    </script>
@endsection

@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugin/timepicker/timepicker.min.css') }}" /> --}}
    <style type="text/css">
        .required:after {
            content: " *";
            color: red;
        }

    </style>
@endsection
