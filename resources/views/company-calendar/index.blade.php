@extends('layouts.layout')
@section('title', 'Company Calendar')

@section('content')
    @php
    $days_name = ['Sun', 'Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat'];
    @endphp

    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="newHrBreadCumb">
                            <h5>Company calendar</h5>
                        </div>
                        <div>
                            <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-today btn-sm mr-2"><i
                                    class="fa fa-calendar"></i>Today</button>
                            @if(Auth::user()->role== 2 || Auth::user()->role== 3)
                            <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-add-holiday btn-sm"><i
                                    class="fa fa-calendar"></i>
                                Holiday</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div id='calendar' style="--main_header_color : {{ $settings->main_header_color }};"></div>
                </div>
                <div class="col-lg-4">
                    <div class="newHrFormGrp bg-lgrey">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="hrprosubHead">
                                    <h5>Employee Information</h5>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center taskInfoIcon">
                                        <div class="eventIcon"></div>
                                        <h6>Event</h6>
                                    </div>
                                    <div class="d-flex align-items-center taskInfoIcon">
                                        <div class="leaveIcon"></div>
                                        <h6>Leave</h6>
                                    </div>
                                    <div class="d-flex align-items-center taskInfoIcon">
                                        <div class="travelIcon"></div>
                                        <h6>Travel</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="event-list" style="margin-top:0.5rem;">
                                    <ul class="list-unstyled events-list">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('modals')
    <div class="modal fade mmodal" id="add-holiday-modal" tabindex="-1" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content mcontent">
                <div class="modal-header mheader bg-grey">
                    <h5 class="modal-title" id="exampleModalLabel">Create New holiday</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mbody">
                    <form id="form-create-holiday" data-action="{{ route('holiday.store') }}" autocomplete="off">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-group date date-range date-start" id="daterange"
                                        data-date-format="mm-dd-yyyy">
                                        <input class="form-control custom-form-control" name="start" type="text">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-group date date-range date-end" data-date-format="mm-dd-yyyy">
                                        <input class="form-control custom-form-control" name="end" type="text">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control custom-form-control"
                                        placeholder="Name">
                                </div>
                            </div>
                            <div class="col-6">

                            </div>
                            <div class="col-6">
                                <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-submit pull-right">Create</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var get_event_url = "{{ route('company-calendar.get-month-event') }}";
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="{{ asset('assets/plugin/core/main.js') }}"></script>
    <script src="{{ asset('assets/plugin/interaction/main.js') }}"></script>
    <script src="{{ asset('assets/plugin/daygrid/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                eventLimit: true, // allow "more" link when too many events
                eventSources: [{
                    url: get_event_url,
                    method: 'GET',
                    extraParams: function(e) {
                        return {
                            // month: fecha.getMonth() + 1,
                            // year: fecha.getFullYear()
                        }
                    },
                    success: function(events) {
                        var content = ""
                        $.each(events, function(i, event) {
                            content += '<li class="fw-600"><span>' + event.date +
                                '</span>' +
                                '<h6>' + event.title + '</h6>' +
                                '</li>'
                        });
                        $('.events-list').html(content)
                        $('.event-title').text(calendar.view.title)
                    },
                    error: function() {
                        alert('error')
                    }
                }],
                displayEventTime: false
            });

            calendar.render();
        });

        $(document).on('click', '.btn-add-holiday', function() {
            $('input[name="start"]').daterangepicker({
                "singleDatePicker": true,
                'minDate': moment(),
                "parentEl": '.date-start'
            }, function(start, end, label) {
                $('input[name="end"]').daterangepicker({
                    "singleDatePicker": true,
                    'minDate': start,
                    "parentEl": '.date-end'
                });

            });
            $('input[name="end"]').daterangepicker({
                "singleDatePicker": true,
                'minDate': moment(),
                "parentEl": '.date-end'
            });
            $('#add-holiday-modal').modal('show')
        })

        $(document).on('submit', '#form-create-holiday', function(e) {
            e.preventDefault()
            var form = $(this)
            var url = form.data('action')
            var data = form.serialize()
            $.ajax({
                    url: url,
                    method: "POST",
                    data: data,
                    beforeSend: function(xhr) {}
                })
                .done(function(data) {
                    var res = JSON.parse(data)
                    if (res.status) {
                        if (res.redirect)
                            window.location.href = res.redirect_url;
                    } else {
                        showAlert('error', res.title, res.text)
                    }

                });

        })
    </script>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="{{ asset('assets/plugin/core/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('assets/plugin/daygrid/main.css') }}" rel='stylesheet' />
@endsection
