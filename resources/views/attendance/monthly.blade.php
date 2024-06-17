@extends('layouts.layout')
@section('title', 'Monthly Attendance')

@section('content')
    @php
    $days_name = ['Sun', 'Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat'];
    @endphp
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <div class="newHrBreadCumb">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Monthly Attendance</h5>
                            <div>
                                <a href="{{ route('attendance.monthly', ['year' => $prev['year'], 'month' => $prev['month']]) }}"
                                    style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm mr-2"><i data-feather="chevron-left"></i>PREV</a>
                                @if (isset($next['show']) && $next['show'])
                                    <a href="{{ route('attendance.monthly', ['year' => $next['year'], 'month' => $next['month']]) }}"
                                        style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm mr-2">NEXT<i data-feather="chevron-right"></i></a>
                                @else
                                    <a href="#" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm  mr-2 disabled">NEXT<i
                                            data-feather="chevron-right"></i></a>
                                @endif
                                <a href="{{ route('attendance.export', ['year' => $current['year'], 'month' => $current['month']]) }}"
                                    style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm "><i data-feather="calendar"></i>Timesheet</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-2">
                    <div class="custom-wrapper">

                        {{-- @dd($attendances) --}}
                        @foreach ($attendances as $department)
                            <?php
                            $holiday = [];
                            if ($department['department']->holidays->count() >= 1) {
                                foreach ($department['department']->holidays as $day) {
                                    $holiday[] = $day->day;
                                }
                            }
                            ?>
                            <div class="table-responsive mb-3">
                                <table class="table table-sm  bg-lgrey table-bordered" style="min-width:100%;">
                                    <thead>
                                        <tr  style="background-color:#1e3070;">
                                            <th class="text-white" style="min-width:160px;"> Name</th>
                                            <th colspan="{{ $month_info['total_day'] + 3 }}" class="text-center text-white">
                                                {{ $department['department']->name }}</th>
                                        </tr>
                                        <tr class="bg-warning">
                                            <th style="min-width:160px;">AD
                                                ({{ $month_info['first_month_eng'] }}/{{ $month_info['last_month_eng'] }})
                                            </th>
                                            @foreach ($headers as $header)
                                                @if (in_array($header['w'], $holiday))
                                                    <th class="text-center holiday">{{ $header['ad'] }}</th>
                                                @else
                                                    <th class="text-center">{{ $header['ad'] }}</th>
                                                @endif
                                            @endforeach
                                            <th class="text-center">W</th>
                                            <th class="text-center present">P</th>
                                            <th class="text-center absent">A</th>

                                        </tr>
                                        <tr >
                                            <th style="min-width:160px;">BS</th>
                                            @foreach ($headers as $header)
                                                @if (in_array($header['w'], $holiday))
                                                    <th class="text-center holiday">{{ $header['bs'] }}</th>
                                                @else
                                                    <th class="text-center">{{ $header['bs'] }}</th>
                                                @endif
                                            @endforeach
                                            <th class="text-center">W</th>
                                            <th class="text-center present">P</th>
                                            <th class="text-center absent">A</th>

                                        </tr>
                                        <tr class="bg-info">
                                            <th style="min-width:160px;">Day</th>
                                            @foreach ($headers as $header)
                                                @if (in_array($header['w'], $holiday))
                                                    <th class="text-center holiday">
                                                        <svg viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg"
                                                            font-size="100">
                                                            <text id="text1" x="120" y="30" fill="white" writing-mode="tb">{{ $header['day'] }}</text>
                                                        </svg>
                                                    </th>
                                                @else
                                                    <th class="text-center">
                                                        <svg viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg"
                                                            font-size="100">
                                                            <text id="text1" x="120" y="30" fill="white"
                                                                writing-mode="tb">{{ $header['day'] }}</text>
                                                        </svg>
                                                    </th>
                                                @endif
                                            @endforeach
                                            <th class="text-center">W</th>
                                            <th class="text-center present">P</th>
                                            <th class="text-center absent">A</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($department['users'])
                                            @foreach ($department['users'] as $user)
                                                <tr>
                                                    <td style="min-width:160px; font-weight:600;">{{ $user['name'] }}</td>
                                                    @foreach ($user['attendance'] as $date)
                                                        @if (isset($date['multiple']) && $date['multiple'])
                                                            <td class="attendance-handle  split"
                                                                data-date="{{ $date['date'] }}"
                                                                data-user-id="{{ $user['id'] }}">
                                                                <span class="left">L</span>
                                                                <span class="right">P</span>
                                                            </td>
                                                        @else
                                                            <td class="attendance attendance-handle {{ $date['class'] }}" data-date="{{ $date['date'] }}"
                                                                data-user-id="{{ $user['id'] }}">{{ $date['text'] }}</td>
                                                        @endif
                                                    @endforeach
                                                    <td class="attendance">{{ $user['total_working_days'] }}</td>
                                                    <td class="attendance present">{{ $user['total_present_days'] }}</td>
                                                    <td class="attendance absent">{{ $user['total_absent_days'] }}</td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('modals')
    <div class="modal fade mmodal" id="attendance-modal" tabindex="-1" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
        </div>
    </div>
@endsection

@section('js')
    <script>
        const get_attendance_detail_url = "{{ route('attendance.get-attendance-detail') }}"
        const mark_present_url = "{{ route('attendance.mark-present') }}";
    </script>
    <script>
        $(document).on('click', '.attendance-handle', function() {
            var user_id = $(this).data('user-id')
            var date = $(this).data('date')

            $.ajax({
                    url: get_attendance_detail_url,
                    method: "POST",
                    data: {
                        'user_id': user_id,
                        'date': date
                    },
                    beforeSend: function(xhr) {

                    }
                })
                .done(function(data) {
                    var res = JSON.parse(data)
                    if (res.status) {
                        $('#attendance-modal').find('.modal-dialog').html(res.view)
                        $('#attendance-modal').modal('show')
                    } else {
                        showAlert('error', res.title, res.text)

                    }

                });
        })
        $('#attendance-modal').on('hidden.bs.modal', function(e) {
            $(this).find('.modal-dialog').html('')
        })
        @if (!$is_real)
            $(document).on('submit','#present-form',function(e){
            e.preventDefault();
            var form=$(this)
            var data=form.serialize()
            $.ajax({
            url: mark_present_url,
            method: "POST",
            data:data,
            beforeSend: function (xhr) {

            }
            })
            .done(function (data) {
            var res = JSON.parse(data)
            if(res.status){
            if (res.redirect)
            location.reload();
            return false;
            window.location.href = res.redirect_url;
            }else{
            showAlert('error', res.title, res.text)
            }

            });

            })
        @endif
    </script>

@endsection
@section('css')
    <style>
        td.split {
            background: #ff2323;
            /* Old browsers */
            background: -moz-linear-gradient(-45deg, #5299d6 50%, green 50%);
            /* FF3.6+ */
            background: -webkit-gradient(linear, left top, right bottom, color-stop(50%, #5299d6), color-stop(50%, green));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(-45deg, #5299d6 50%, green 50%);
            /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(-45deg, #5299d6 50%, green 50%);
            /* Opera 11.10+ */
            background: -ms-linear-gradient(-45deg, #5299d6 50%, green 50%);
            /* IE10+ */
            background: linear-gradient(135deg, #5299d6 50%, green 50%);
            /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#5299d6', endColorstr='green', GradientType=1);
            /* IE6-9 fallback on horizontal gradient */
        }

        td.split>.right {
            float: right;
            padding-top: 7px;
        }

        td.split>.left {
            float: left;
        }

        .attendance {
            font-size: 12px !important;
            font-weight: 600;
            padding: 9px 12px !important;
            color: white;
        }

        .present {
            background-color: green !important;

        }

        .absent {
            /*background-color:blue!important;*/
            background-color: #5299d6 !important;
        }

        .holiday {
            background-color: red !important;
        }

        .paid-leave {
            /*background-color:blue!important;*/
            background-color: #5299d6 !important;
        }

        .unpaid-leave {
            /*background-color:blue!important;*/
            background-color: #5299d6 !important;
        }

        .attendance-handle {
            cursor: pointer;
            color: white;
        }

    </style>
@endsection
