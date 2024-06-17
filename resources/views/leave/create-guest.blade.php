@extends('layouts.guest')
@section('title','Request Leave')

@section('content')
@php
$days_name=['Sun','Mon','Tue','Wed', 'Thurs', 'Fri','Sat'];
@endphp
    <div class="container-fluid" style="background: #fff;">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="calendar-title">
                    <div class="pull-left">
                        <h2 class="fw-600 mb-0">Request a leave</h2>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <form id="form-create-leave" data-action="{{ route('leave.store')}}" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-2">
                                    <label><strong>Leave Start</strong></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="input-group date date-range date-start" id="daterange"
                                            data-date-format="mm-dd-yyyy">
                                            <input class="form-control custom-form-control" name="start" type="text" required>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-2">
                                    <label><strong>Leave End</strong></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group date date-range date-end" data-date-format="mm-dd-yyyy">
                                            <input class="form-control custom-form-control" name="end" type="text" required>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-part-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label><strong>Email Address</strong></label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input name="email" type="email" class="form-control custom-form-control"
                                                placeholder="Email" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-submit pull-right btn-check-email">Next</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade mmodal" id="create-leave-modal" tabindex="-1" data-backdrop="static">
        
    </div>
@endsection

@section('js')
<script>
    var get_event_url = "{{route('company-calendar.get-month-event')}}";
    var get_leave_form = "{{route('leave.get.form.guest')}}";
    var check_user_url = "{{route('leave.check.user')}}";
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('assets/plugin/core/main.js') }}"></script>
<script src="{{ asset('assets/plugin/interaction/main.js') }}"></script>
<script src="{{ asset('assets/plugin/daygrid/main.js')}}"></script>
<script>
    $('input[name="start"]').daterangepicker({
            "singleDatePicker": true,
            "minDate": moment(),
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
  
        $('input[name="end"]').daterangepicker({
            "singleDatePicker": true,
            "minDate": moment(),
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
        
    $(document).on('submit', '#form-create-leave', function (e) {
        e.preventDefault()
        var form = $(this)
        var url = form.data('action')
        var data = form.serialize()
        $.ajax({
                url: url,
                method: "POST",
                data: data,
                beforeSend: function (xhr) {

                }
            })
            .done(function (data) {
                var res = JSON.parse(data)
                if (res.status) {
                    if (res.redirect)
                        window.location.href = res.redirect_url;
                } else {
                    showAlert('error', res.title, res.text)
                }

            });

    })

    $(document).on('click','.btn-check-email',function(e){
        var email=$('#form-create-leave').find('input[name="email"]').val()
        $.ajax({
                url: check_user_url,
                method: "POST",
                data: {
                    email:email
                },
                beforeSend: function (xhr) {

                }
            })
            .done(function (data) {
                var res = JSON.parse(data)
                if (res.status) {
                    $('.form-part-2').html(res.view)
                    if (res.redirect)
                        window.location.href = res.redirect_url;
                } else {
                    showAlert('error', res.title, res.text)
                }

            });
    })

    

    function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    $('#create-leave-modal').on('hidden.bs.modal', function (e) {
        $("input:radio[name='leave_type']").each(function(i) {         
            if(i==0){
                this.checked = true;
            }else{
                this.checked = false;
            }
        });
        $(this).find('.day-breakdown').html('')
    })
</script>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="{{ asset('assets/plugin/core/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('assets/plugin/daygrid/main.css')}}" rel='stylesheet' />
@endsection
