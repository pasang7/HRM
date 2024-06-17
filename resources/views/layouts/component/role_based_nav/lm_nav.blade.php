<li class="list-item">
    <p class="report-link">
        <a style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary" data-toggle="collapse" href="#collapseLeave" role="button" aria-expanded="false"
            aria-controls="collapseLeave" title="Leave">
            <span><i data-feather="target"></i></span><span class="nav-label">Leave

            </span>
        </a>
    </p>
    <div class="collapse" id="collapseLeave">
        <div class="card card-body card-design">
            <ul class="report-submenu list-unstyled">
                <li>
                    <a href="{{ route('leave.index') }}" title="Leave Requests"><span><i data-feather="minus"
                                class="minusIcon"></i></span> <span class="nav-label">
                            Requests</span>

                            {{-- <span class="badge badge-danger">{{ \App\Helpers\Helper::calculateLeaveRequest() ? \App\Helpers\Helper::calculateLeaveRequest() : '' }}</span> --}}
                    </a>
                </li>

                <li>
                    <a href="{{ route('leave.create') }}" title="Request a leave"><span><i data-feather="minus"
                                class="minusIcon"></i></span>
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
            aria-controls="collapseTravel" title="Travel Records">
            <span><i data-feather="send"></i></span><span class="nav-label">Travel Records</span>
        </a>
    </p>
    <div class="collapse" id="collapseTravel">
        <div class="card card-body card-design">
            <ul class="report-submenu list-unstyled">
                <li>
                    <a href="{{ route('travel.review') }}" title="Review Request"><span><i data-feather="minus"
                                class="minusIcon"></i></span>
                        <span class="nav-label">Review Request</span>
                        {{-- <span class="badge badge-danger">{{ \App\Helpers\Helper::calculateTravelRequest() }}</span> --}}
                    </a>
                </li>
                <li>
                    <a href="{{ route('travel.create') }}" title="Request Form"><span><i data-feather="minus"
                                class="minusIcon"></i></span>
                        <span class="nav-label"> Request Form</span> </a>
                </li>

            </ul>
        </div>
    </div>
</li>

<li class="list-item">
    <a href="{{ route('project.index') }} " title=" Project"><span><i data-feather="command"></i></span><span
            class="nav-label">Project</span></a>
</li>
<li class="list-item">
    <p class="report-link">
        <a style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary" data-toggle="collapse" href="#collapseReports" role="button" aria-expanded="false"
            aria-controls="collapseReports" title=" Reports">
            <span><i data-feather="clipboard"></i></span><span class="nav-label">Reports</span>
        </a>
    </p>
    <div class="collapse" id="collapseReports">
        <div class="card card-body card-design">
            <ul class="report-submenu list-unstyled">
                <li>
                    <a href="{{ route('reports.staff-wise.index') }}"><span class="list-style"><i
                                data-feather="minus" class="minusIcon"></i></span> <span class="nav-label"
                            title=" Staff Wise
                            Report"> Staff Wise
                            Report</span></a>
                </li>
                <li>
                    <a href="{{ route('reports.project-wise.index') }}" title="
                             Project Wise Report"><span><i data-feather="minus" class="minusIcon"></i></span>
                        <span class="nav-label">
                            Project Wise Report
                        </span> </a>
                </li>
            </ul>
        </div>
    </div>
</li>
<li class="list-item">
    <a href="{{ route('company-calendar.index') }}" title="
                             Calendar"><span><i data-feather="calendar"></i></span><span class="nav-label">
            Calendar</span></a>
</li>
<li class="list-item">
    <a href="{{ route('birthday.index') }}" title="
                             Birthday"><span><i data-feather="gift"></i></span>
        <span class="nav-label">Birthday
            @if (isset($nsp_birthday['alert']) && $nsp_birthday['alert'])
                <span class="badge badge-danger">{{ $nsp_birthday['count'] }}</span>
            @endif
        </span>
    </a>
</li>

<li class="list-item">
    <p class="report-link">
        <a style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary" data-toggle="collapse" href="#collapseReport" role="button" aria-expanded="false"
            aria-controls="collapseReport" title="
                             Progress Report">
            <span><i data-feather="pie-chart"></i></span><span class="nav-label">Progress Report</span>
        </a>
    </p>
    <div class="collapse" id="collapseReport">
        <div class="card card-body card-design">
            <ul class="report-submenu list-unstyled">
                <li>
                    <a href="{{ route('report.create') }}" title="
                             Send Report"><span class="list-style"><i data-feather="minus"
                                class="minusIcon"></i></span>
                        <span class="nav-label"> Send Report</span></a>
                </li>
                <li>
                    <a href="{{ route('report.my-report') }}" title="
                             My Report"><span><i data-feather="minus" class="minusIcon"></i></span>
                        <span class="nav-label">My Reports</span> </a>
                </li>
            </ul>
        </div>
    </div>
</li>
