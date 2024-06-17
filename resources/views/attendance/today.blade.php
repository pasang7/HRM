@extends('layouts.layout')
@section('title', 'Today`s Attendance')
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
                            <h5 class="mb-0">Today Attendance</h5>
                            <a href="{{ route('attendance.export') }} " title=" Create Project"
                                style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm"><i data-feather="file-text"></i>Export Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">


                    @foreach ($attendances as $n => $attendance)

                        <div class="hrproTableHead mt-2">
                            <h5>{{ $attendance['department']->name }}</h5>

                        </div>
                        <div class="table-responsive mb-3">
                            <table class="table">
                                <thead class="c-thead">
                                    <tr>
                                        <th scope="col">Shift</th>
                                        <th scope="col">Clockin</th>
                                        <th scope="col">Clockout</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    @foreach ($attendance['department']->shifts as $shift)
                                        <tr>
                                            <th scope="row" style="width:30px;">{{ $loop->iteration }}</th>
                                            <td>{{ date('g:i a', strtotime($shift->clockin)) }}</td>
                                            <td>{{ date('g:i a', strtotime($shift->clockout)) }}</td>
                                            <td class="p-0">
                                                @if (Carbon\Carbon::now()->gt(Carbon\Carbon::parse($shift->clockin)) && Carbon\Carbon::parse($shift->clockout)->gt(Carbon\Carbon::now()))
                                                    <span class="badge badge-success">Running</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="table table-bordered mt-3" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Attendance</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($attendance['users'])
                                        @foreach ($attendance['users'] as $user)
                                            @php
                                                $is_present = false;
                                                $is_main_late = false;
                                                $is_leave = false;
                                                $is_absent = false;
                                                $is_wfh = false;
                                                $is_verified = true;
                                            @endphp
                                            @if (App\Models\AcceptedLeave::where('user_id', $user['user']->id)->whereDate('date', Carbon\Carbon::today())->count() > 0)
                                                <?php $is_leave = true; ?>
                                            @endif
                                            @if (App\Models\Attendance::where('user_id', $user['user']->id)->whereDate('date', Carbon\Carbon::today())->where('is_absent', 1)->count() > 0)
                                                <?php $is_absent = true; ?>
                                            @endif
                                            @if (App\Models\Attendance::where('user_id', $user['user']->id)->whereDate('date', Carbon\Carbon::today())->where('is_wfh', 1)->count() > 0)
                                                <?php $is_wfh = true; ?>
                                            @endif
                                            <tr>
                                                <td>{{ $user['user']->name }}</td>
                                                <td>
                                                    <table class="table table-bordered table-sm mb-0" style="width:100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Clockin</th>
                                                                <th>Clockout</th>
                                                                <th>Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($user['user']->today_attendance->count() > 0)
                                                                <?php $is_present = true; ?>
                                                                @foreach ($user['user']->today_attendance as $today_attendance)
                                                                    @php
                                                                        $is_late = false;
                                                                    @endphp
                                                                    <tr>
                                                                        @if ($is_present && !$is_absent && !$is_leave)
                                                                            <td>
                                                                                <a class="image"
                                                                                    data-image="{{ $today_attendance->clockin_verification }}"
                                                                                    href="#">{{ date('g:i a', strtotime($today_attendance->clockin)) }}</a>
                                                                            </td>
                                                                            @if ($today_attendance->clockout)
                                                                                <td>
                                                                                    <a class="image"
                                                                                        data-image="{{ $today_attendance->clockout_verification }}"
                                                                                        href="#">{{ date('g:i a', strtotime($today_attendance->clockout)) }}</a>
                                                                                </td>
                                                                            @else
                                                                                <td>-</td>
                                                                            @endif
                                                                            @if (Carbon\Carbon::parse($today_attendance->clockin)->gt(Carbon\Carbon::parse($today_attendance->shift->clockin)) && Carbon\Carbon::parse($today_attendance->clockin)->gt(Carbon\Carbon::parse($settings->max_allow_time)))
                                                                                @php
                                                                                    $is_late = true;
                                                                                    $is_main_late = true;
                                                                                @endphp
                                                                            @endif
                                                                            <td>
                                                                                @if ($today_attendance->status == 'unverified')
                                                                                    @php
                                                                                        $is_verified = false;
                                                                                    @endphp
                                                                                    <span
                                                                                        class="badge badge-danger">Unverified</span><br>
                                                                                @endif

                                                                                {!! $today_attendance->remarks !!}
                                                                                @if ($today_attendance->wfhBy)
                                                                                    Work From Home By:
                                                                                    {{ $today_attendance->wfhBy->name }}
                                                                                @endif
                                                                            </td>
                                                                        @else
                                                                            <td colspan=3 class="text-center">
                                                                                {!! $today_attendance->remarks !!}
                                                                                @if ($today_attendance->absentedBy)
                                                                                    <br>Marked Absent By:
                                                                                    {{ $today_attendance->absentedBy->name }}
                                                                                @endif
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan=3 class="text-center">Not Clocked In </td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>
                                                    @if ($is_present && !$is_leave && !$is_absent)
                                                        <span class="badge badge-success">Present</span> <br>
                                                    @elseif($is_leave)
                                                        <span class="badge badge-info">On Leave</span> <br>
                                                    @elseif($is_absent)
                                                        <span class="badge badge-danger">Absent</span> <br>
                                                    @else
                                                    @endif
                                                    @if ($is_main_late)
                                                        <span class="badge badge-warning">Late</span> <br>
                                                    @endif
                                                    @if (!$is_verified)
                                                        <span class="badge badge-danger">Unverified</span> <br>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($is_absent || $is_leave || !$is_present)
                                                        @if (!$is_absent && !$is_leave)
                                                            <button style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm mr-2" data-toggle="modal"
                                                                data-target="#markAbsentModal-{{ $user['user']->slug }}"><i
                                                                    data-feather="check"></i>Mark
                                                                Absent</button>
                                                            <!-- Mark Absent Modal -->
                                                            <div class="modal fade"
                                                                id="markAbsentModal-{{ $user['user']->slug }}" tabindex="-1"
                                                                role="dialog" aria-labelledby="markAbsentModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="markAbsentModalLabel">Mark
                                                                                Absent
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form method="post"
                                                                            action="{{ route('attendance.mark-absent') }}">
                                                                            @csrf
                                                                            <input name="slug" type="hidden"
                                                                                value="{{ $user['user']->slug }}" readonly>
                                                                            <div class="modal-body">
                                                                                <div class="container">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <label>Are you sure to
                                                                                                mark
                                                                                                absent for
                                                                                                {{ $user['user']->name }}?</label>
                                                                                        </div>
                                                                                        @if (count($user['user']->department->shifts) > 1)
                                                                                            <div class="col-md-12">
                                                                                                <label>Select
                                                                                                    Shift</label>
                                                                                                <select name="shift_id"
                                                                                                    class="form-control">
                                                                                                    @foreach ($user['user']->department->shifts as $shifts)
                                                                                                        <option
                                                                                                            value="{{ $shifts->id }}">
                                                                                                            {{ date('h:i A', strtotime($shifts->clockin)) }}
                                                                                                            to
                                                                                                            {{ date('h:i A', strtotime($shifts->clockout)) }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        @else
                                                                                            @foreach ($user['user']->department->shifts as $shifts)
                                                                                                <input name="shift_id"
                                                                                                    value="{{ $shifts->id }}"
                                                                                                    type="hidden">
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="form-gruop">
                                                                                        <label>Enter Remarks <span
                                                                                                class="text-danger">*</span></label>
                                                                                        <textarea class="form-control" rows="3" name="remarks" placeholder="Remarks Here" required></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary">Yes,
                                                                                    Mark
                                                                                    Absent</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <button style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm" data-toggle="modal"
                                                                data-target="#wfhModal-{{ $user['user']->slug }}"><i
                                                                    data-feather="home"></i>Work
                                                                From
                                                                Home</button>
                                                            <!-- Work From Home Modal -->
                                                            <div class="modal fade" id="wfhModal-{{ $user['user']->slug }}"
                                                                tabindex="-1" role="dialog" aria-labelledby="wfhModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="wfhModalLabel">
                                                                                Work From Home
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form method="post"
                                                                            action="{{ route('attendance.wfh.submit') }}">
                                                                            @csrf
                                                                            <input name="slug" type="hidden"
                                                                                value="{{ $user['user']->slug }}" readonly>
                                                                            <div class="modal-body">
                                                                                <div class="container">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <label>Assinged
                                                                                                {{ $user['user']->name }}
                                                                                                in work from
                                                                                                home?</label>
                                                                                        </div>
                                                                                        @if (count($user['user']->department->shifts) > 1)
                                                                                            <div class="col-md-12">
                                                                                                <label>Select
                                                                                                    Shift</label>
                                                                                                <select name="shift_id"
                                                                                                    class="form-control">
                                                                                                    @foreach ($user['user']->department->shifts as $shifts)
                                                                                                        <option
                                                                                                            value="{{ $shifts->id }}">
                                                                                                            {{ date('h:i A', strtotime($shifts->clockin)) }}
                                                                                                            to
                                                                                                            {{ date('h:i A', strtotime($shifts->clockout)) }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        @else
                                                                                            @foreach ($user['user']->department->shifts as $shifts)
                                                                                                <input name="shift_id"
                                                                                                    value="{{ $shifts->id }}"
                                                                                                    type="hidden">
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="form-gruop">
                                                                                        <label>Enter Remarks <span
                                                                                                class="text-danger">*</span></label>
                                                                                        <textarea class="form-control" rows="3" name="remarks" placeholder="Remarks Here" required></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary">Yes,
                                                                                    Work
                                                                                    From Home</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @elseif($is_leave && !$is_absent)
                                                            <button style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm" data-toggle="modal"
                                                                data-target="#cancelLeave-{{ $user['user']->slug }}"><i
                                                                    data-feather="x"></i>Cancel
                                                                Leave</button>
                                                            <!-- Cancel Absent Modal -->
                                                            <div class="modal fade" id="cancelLeave-{{ $user['user']->slug }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="cancelLeaveModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="cancelLeaveLabel">
                                                                                Cancel Leave
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form method="post"
                                                                            action="{{ route('attendance.cancelLeave') }}">
                                                                            @csrf
                                                                            <input name="slug" type="hidden"
                                                                                value="{{ $user['user']->slug }}" readonly>
                                                                            <div class="modal-body">
                                                                                <label>Are you sure to cancel todays
                                                                                    leave of
                                                                                    {{ $user['user']->name }}?</label>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-danger">Yes,
                                                                                    Cancel
                                                                                    Leave</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @elseif($is_absent)
                                                            <button style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm mr-2" data-toggle="modal"
                                                                data-target="#cancelAbsentModal-{{ $user['user']->slug }}"><i
                                                                    data-feather="x"></i>Cancel
                                                                Absent</button>
                                                            <!-- Cancel Absent Modal -->
                                                            <div class="modal fade"
                                                                id="cancelAbsentModal-{{ $user['user']->slug }}" tabindex="-1"
                                                                role="dialog" aria-labelledby="cancelAbsentModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="cancelAbsentModalLabel">Cancel
                                                                                Absent</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form method="post"
                                                                            action="{{ route('attendance.cancelAbsent') }}">
                                                                            @csrf
                                                                            <input name="slug" type="hidden"
                                                                                value="{{ $user['user']->slug }}" readonly>
                                                                            <div class="modal-body">
                                                                                <label>Are you sure to cancel
                                                                                    {{ $user['user']->name }}?</label>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-danger">Yes,
                                                                                    Cancel
                                                                                    Absent</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm" data-toggle="modal"
                                                                data-target="#cancelLeave-{{ $user['user']->slug }}"><i
                                                                    data-feather="x"></i>Cancel
                                                                Leave</button>
                                                            <!-- Cancel Absent Modal -->
                                                            <div class="modal fade" id="cancelLeave-{{ $user['user']->slug }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="cancelLeaveModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="cancelLeaveLabel">
                                                                                Cancel Leave
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form method="post"
                                                                            action="{{ route('attendance.cancelLeave') }}">
                                                                            @csrf
                                                                            <input name="slug" type="hidden"
                                                                                value="{{ $user['user']->slug }}" readonly>
                                                                            <div class="modal-body">
                                                                                <label>Are you sure to cancel todays
                                                                                    leave of
                                                                                    {{ $user['user']->name }}?</label>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-danger">Yes,
                                                                                    Cancel
                                                                                    Leave</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                        @endif
                                                    @elseif(!$is_verified && Auth::user()->role == 3)
                                                        <button style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm" data-toggle="modal"
                                                            onclick="verifyAttendance('{{ $n }}', {{ $loop->index }})">
                                                            Verify
                                                        </button>
                                                    @endif
                                                    <!-- Cancel Work From Home Function -->
                                                    @if ($is_wfh)
                                                        {{-- <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#cancelWFHModal-{{ $n }}">Cancel Work From Home</button> --}}
                                                    @endif
                                                </td>
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

    @include('attendance.verification-modal')
@endsection
@section('modals')
    <div class="modal fade mmodal" id="add-holiday-modal" tabindex="-1" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content mcontent">
                <div class="modal-header mheader bg-grey">
                    <h5 class="modal-title" id="exampleModalLabel">Create new holiday</h5>
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
                            <div class="col-6"></div>
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
    @include('attendance.verification-js')
@endsection
@section('css')

@endsection
