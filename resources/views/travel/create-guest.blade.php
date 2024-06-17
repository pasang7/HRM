@extends('layouts.guest')
@section('title','Request Leave')

@section('content')
@php
$days_name=['Sun','Mon','Tue','Wed', 'Thurs', 'Fri','Sat'];
@endphp
    <div class="container-fluid">
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
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12"></div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id='calendar'></div>
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
    document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: ['interaction', 'dayGrid'],
                    header: {
                        left: ' prev',
                        center: 'title',
                        right: 'next'
                    },
                    defaultDate: moment().format(),
                    editable: false,
                    allDaySlot: false,
                    navLinks: false, // can click day/week names to navigate views
                    selectable: true,
                    selectHelper: false,
                    unselectAuto:true,
                    select: function (range) {
                        var start=moment(range.startStr);
                        var end=moment(range.endStr).subtract(1, 'd');
                        
                        
                        if (start.isBefore(moment().subtract(1, 'd'))) {                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Cannot select that date!'
                            })
                        }else{

                            $.ajax({
                                url: get_leave_form,
                                method: "POST",
                                beforeSend: function (xhr) {
                                    
                                }
                            })
                            .done(function (data) {
                                var res = JSON.parse(data)
                                if(res.status){
                                    $('#create-leave-modal').html(res.view)
                                    $('#create-leave-modal').modal('show')
                                    $('input[name="start"]').daterangepicker({
                                        "singleDatePicker": true,
                                        'minDate': start,
                                        'startDate' :start,
                                        "parentEl": '.date-start'
                                    }, function (start, end, label) {
                                        $('input[name="end"]').daterangepicker({
                                            "singleDatePicker": true,
                                            'minDate': start,
                                            "parentEl": '.date-end'
                                        });

                                    });
                                    $('input[name="end"]').daterangepicker({
                                        "singleDatePicker": true,
                                        'minDate': start,
                                        'startDate' :end,
                                        "parentEl": '.date-end'
                                    }, function (start, end, label) {

                                    });
                                }else{
                                    showAlert('error', res.title, res.text)
                                }
                                
                            });
                            return false;
                        }
                        return false;
                    },
                    eventLimit: true, // allow "more" link when too many events


                });



        calendar.render();
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
