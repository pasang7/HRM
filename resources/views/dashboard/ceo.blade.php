<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
    <div class="hrDashboardData">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 mb-3 pr-0">
                <a href="{{ route('leave.index') }}">
                    <div class="newHrDashCard">
                        <div class="d-flex align-items-center">
                            <div class="dashHrIcon">
                                <img src="{{ asset('theme/images/leave.png') }}" alt="">
                            </div>
                            <div class="dashHrInfo">
                                <h6>Leave Request</h6>
                                {{-- <h2>{{ \App\Helpers\Helper::calculateLeaveApprove() ? \App\Helpers\Helper::calculateLeaveApprove() : '0' }}</h2> --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-3 pr-0">
                <a href="{{ route('travel.index') }}">
                    <div class="newHrDashCard">
                        <div class="d-flex align-items-center">
                            <div class="dashHrIcon">
                                <img src="{{ asset('theme/images/travel.png') }}" alt="">
                            </div>
                            <div class="dashHrInfo">
                                <h6>Travel Request</h6>
                                <h2>{{ \App\Helpers\Helper::calculateTravelApproval() ? \App\Helpers\Helper::calculateTravelApproval() : '0' }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-3 pr-0">
                <a href="{{ route('project.index') }}">
                    <div class="newHrDashCard">
                        <div class="d-flex align-items-center">
                            <div class="dashHrIcon">
                                <img src="{{ asset('theme/images/project.png') }}" alt="">
                            </div>
                            <div class="dashHrInfo">
                                <h6>Projects</h6>
                                <h2>{{ $all_projects->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-3 pr-0">
                <a href="{{ route('department.index') }}">
                    <div class="newHrDashCard">
                        <div class="d-flex align-items-center">
                            <div class="dashHrIcon">
                                <img src="{{ asset('theme/images/department.png') }}" alt="">
                            </div>
                            <div class="dashHrInfo">
                                <h6>Total Departments</h6>
                                <h2> {{ $departments > 1 ? $departments : $departments }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-3 pr-0">
                <a href="{{ route('reports.staff-wise.index') }}">
                    <div class="newHrDashCard">
                        <div class="d-flex align-items-center">
                            <div class="dashHrIcon">
                                <img src="{{ asset('theme/images/report.png') }}" alt="">
                            </div>
                            <div class="dashHrInfo">
                                <h6>Staff Reports</h6>
                                <h2>{{ $reports }}</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-3 pr-0">
                <a href="{{ route('user.index') }}">
                    <div class="newHrDashCard">
                        <div class="d-flex align-items-center">
                            <div class="dashHrIcon">
                                <img src="{{ asset('theme/images/staff.png') }}" alt="">
                            </div>
                            <div class="dashHrInfo">
                                <h6>Total Employees</h6>
                                <h2> {{ $employees->count() > 1 ? $employees->count() : $employees->count() }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-12 pr-0">
                <div class="hrproTableHead mt-2">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0">Attendance Records</h5>
                        <div class="d-flex align-items-center recButon">
                            <a href="{{ route('attendance.today') }}"
                                style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm d-flex align-items-center mr-3"><i
                                    class="fa fa-clock mr-1"></i>Today's
                                Attendance</a>
                            <a href="{{ route('attendance.monthly') }}"
                                style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm d-flex align-items-center "><i
                                    class="fa fa-calendar mr-1"></i>Monthly
                                Attendance</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 mb-3 pr-0">
                <div class="newHrDashCard presentBg">
                    <div class="dashHrInfo">
                        <h6 class="text-success">Present Today</h6>
                        <h2 class="text-success">{{ $attendance_count['present'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 mb-3 pr-0">
                <div class="newHrDashCard lateBg">
                    <div class="dashHrInfo">
                        <h6 class="text-warning">Late Today</h6>
                        <h2 class="text-warning">{{ $attendance_count['late'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 mb-3 pr-0">
                <div class="newHrDashCard absentBg">
                    <div class="dashHrInfo">
                        <h6 class="text-danger">Absent Today</h6>
                        <h2 class="text-danger">{{ $attendance_count['absent'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 mb-3 pr-0">
                <div class="newHrDashCard leaveBg">
                    <div class="dashHrInfo">
                        <h6 class="text-info">On Leave Today</h6>
                        <h2 class="text-info">{{ $attendance_count['on_leave'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mb-0 pr-0">
                @include('dashboard.chart_components.advanceList')
            </div>
            <div class="col-lg-12 pr-0">
                <div class="hrproTableHead mt-2">
                    <h5>Total Employees</h5>
                </div>
                <div class="overViewBgGrp">
                    @includeIf('dashboard.chart_components.employee_count_chart')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="col-lg-12 mb-2">
            <div class="hrproTableHead">
                <h5>Employee Overview</h5>
            </div>
            <div class="overViewBgGrp">
                @includeIf('dashboard.chart_components.employee_diversity')
            </div>
        </div>
        <div class="col-lg-12  mt-1">
            <div class="hrproTableHead mt-2">
                <h5>Line Managers</h5>
            </div>
        </div>
        <div class="col-lg-12">
            @if (count($line_managers) > 0)
                <table class="table  table-sm" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Name </th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($line_managers as $lm => $line_manager)
                            <tr>
                                <td>{{ $line_manager->name }}</td>
                                <td>{{ $line_manager->department->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center col-md-12 pt-4 pb-4">
                    <p>No Line Manager Found!</p>
                    <a href="{{ route('user.create') }}" class="btn btn-info">Create Here</a>
                </div>
            @endif
        </div>
        <div class="col-lg-12 mt-3">

            @include('dashboard.chart_components.holidayBirthday')
        </div>
    </div>
</div>
