<li class="list-item">
    <p class="report-link">
        <a style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary" data-toggle="collapse" href="#collapseSetup" role="button" aria-expanded="false"
            aria-controls="collapseSetup">
            <span><i data-feather="settings"></i></span><span class="nav-label">Settings</span>
        </a>
    </p>
    <div class="collapse" id="collapseSetup">
        <div class="card card-body card-design">
            <ul class="report-submenu list-unstyled">
                <li>
                    <a href="{{ route('company-setting.index') }}"><span class="list-style"><i data-feather="minus"></i></span> <span class="nav-label">
                            Company Setup</span></a>
                </li>
                <li>
                    <a href="{{ route('leave-type.index') }}"><span><i data-feather="minus"></i></span>
                        <span class="nav-label"> Leave Setup </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</li>
<li class="list-item">
    <p class="report-link">
        <a style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary" data-toggle="collapse" href="#collapseHRmgmt" role="button" aria-expanded="false"
            aria-controls="collapseHRmgmt">
            <span><i data-feather="users"></i></span><span class="nav-label">HR</span>
        </a>
    </p>
    <div class="collapse" id="collapseHRmgmt">
        <div class="card card-body card-design">
            <ul class="report-submenu list-unstyled">
                <li>
                    <a href="{{ route('department.index') }}"><span><i data-feather="minus"></i></span> <span
                            class="nav-label"> Departments</span></a>
                </li>
                <li>
                    <a href="{{ route('designation.index') }}"><span><i data-feather="minus"></i></span> <span
                            class="nav-label"> Designations</span></a>
                </li>
                <li>
                    <a href="{{ route('user.index') }}"><span><i data-feather="minus"></i></span> <span
                            class="nav-label"> Employee</span></a>
                </li>

            </ul>
        </div>
    </div>
</li>

<li class="list-item">
    <p class="report-link">
        <a style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary" data-toggle="collapse" href="#collapseAttendance" role="button" aria-expanded="false"
            aria-controls="collapseAttendance">
            <span><i  data-feather="clock"></i></span><span class="nav-label">Attendance</span>
        </a>
    </p>
    <div class="collapse" id="collapseAttendance">
        <div class="card card-body card-design">
            <ul class="report-submenu list-unstyled">
                <li>
                    <a href="{{ route('attendance.today') }}"><span class="list-style"><i data-feather="minus"></i></span> <span class="nav-label">
                            Today</span></a>
                </li>
                <li>
                    <a href="{{ route('attendance.monthly') }}"><span><i data-feather="minus"></i></span>
                        <span class="nav-label">
                            Monthly</span> </a>
                </li>
            </ul>
        </div>
    </div>
</li>

<li class="list-item">
    <p class="report-link">
        <a style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary" data-toggle="collapse" href="#collapseLeave" role="button" aria-expanded="false"
            aria-controls="collapseLeave">
            <span><i data-feather="feather"></i></span><span class="nav-label">Leave
                {{-- @if (isset($nsp_leave['alert']) && $nsp_leave['alert'])
            <span class="badge badge-danger">{{$nsp_leave['count']}}</span>
            @endif --}}
            </span>
        </a>
    </p>
    <div class="collapse" id="collapseLeave">
        <div class="card card-body card-design">
            <ul class="report-submenu list-unstyled">
                <li>
                    <a href="{{ route('leave.index') }}"><span><i data-feather="minus"></i></span> <span
                            class="nav-label">
                            Requests</span>
                        {{-- <span class="badge badge-danger">{{ \App\Helpers\Helper::calculateLeaveRequest() ? \App\Helpers\Helper::calculateLeaveRequest() : '' }}</span> --}}
                    </a>
                </li>
                <li>
                    <a href="{{ route('leave.create') }}"><span><i data-feather="minus"></i></span>
                        <span class="nav-label">
                            Request a leave</span> </a>
                </li>
            </ul>
        </div>
    </div>
</li>

<li class="list-item">
    <p class="report-link">
        <a style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary" data-toggle="collapse" href="#collapseTravel" role="button" aria-expanded="false"
            aria-controls="collapseTravel">
            <span><i data-feather="send"></i></span><span class="nav-label">Travel</span>
        </a>
    </p>
    <div class="collapse" id="collapseTravel">
        <div class="card card-body card-design">
            <ul class="report-submenu list-unstyled">
                <li>
                    <a href="{{ route('travel.index') }}"><span><i data-feather="minus"></i></span>
                        <span class="nav-label">Approve Request</span>
                        {{-- <span class="badge badge-danger">{{ \App\Helpers\Helper::calculateTravelApproval() }}</span> --}}
                    </a>
                </li>
                <li>
                    <a href="{{ route('travel.create') }}"><span><i data-feather="minus"></i></span>
                        <span class="nav-label"> Request Form</span> </a>
                </li>
            </ul>
        </div>
    </div>
</li>



<li class="list-item">
    <p class="report-link">
        <a style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary" data-toggle="collapse" href="#collapsePayrollMenu" role="button"
            aria-expanded="false" aria-controls="collapsePayrollMenu">
            <span><i data-feather="dollar-sign"></i></span><span class="nav-label">Payroll</span>
        </a>
    </p>
    <div class="collapse" id="collapsePayrollMenu">
        <div class="card card-body card-design">
            <ul class="report-submenu list-unstyled">
                <li>
                    <a href="{{ route('salary.sheet.history') }}">
                        <span class="list-style"><i data-feather="minus"></i></span>
                        <span class="nav-label"> Generate SalarySheet</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</li>

<li class="list-item">
    <a href="{{ route('project.index') }}"><span><i data-feather="sun"></i></span><span
            class="nav-label">Project</span></a>
</li>
<li class="list-item">
    <p class="report-link">
        <a style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary" data-toggle="collapse" href="#collapseReports" role="button" aria-expanded="false"
            aria-controls="collapseReports">
            <span><i data-feather="file"></i></span><span class="nav-label">Reports</span>
        </a>
    </p>
    <div class="collapse" id="collapseReports">
        <div class="card card-body card-design">
            <ul class="report-submenu list-unstyled">
                <li>
                    <a href="{{ route('reports.staff-wise.index') }}"><span class="list-style"><i data-feather="minus"></i></span> <span class="nav-label"> Staff Wise
                            Report</span></a>
                </li>
                <li>
                    <a href="{{ route('reports.project-wise.index') }}"><span><i data-feather="minus"></i></span>
                        <span class="nav-label">
                            Project Wise Report
                        </span> </a>
                </li>
            </ul>
        </div>
    </div>
</li>
<li class="list-item">
    <a href="{{ route('company-calendar.index') }}"><span><i data-feather="calendar"></i></span><span
            class="nav-label">Company Calendar</span></a>
</li>
<li class="list-item">
    <a href="{{ route('birthday.index') }}"><span><i data-feather="gift"></i></span>
        <span class="nav-label">Birthday
            @if (isset($nsp_birthday['alert']) && $nsp_birthday['alert'])
                <span class="badge badge-danger">{{ $nsp_birthday['count'] }}</span>
            @endif
        </span>
    </a>
</li>
