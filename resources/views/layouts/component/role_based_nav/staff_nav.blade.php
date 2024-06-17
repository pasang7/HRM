
<li class="list-item">
    <a href="{{ route('report.create') }}"><span><i data-feather="navigation"></i></span><span
            class="nav-label">Send Report</span></a>
</li>

<li class="list-item">
    <a href="{{ route('report.my-report') }}"><span><i data-feather="bookmark"></i></span><span
            class="nav-label">My Reports</span></a>
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
                {{-- <li>
                    <a href="{{ route('leave.index') }}"><span><i data-feather="minus"></i></span> <span
                            class="nav-label">
                            Requests</span>
                        <span class="badge badge-danger">{{ \App\Helpers\Helper::calculateLeaveRequest() ? \App\Helpers\Helper::calculateLeaveRequest() : '' }}</span>
                    </a>
                </li> --}}
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
                        <span class="nav-label"> Travel History</span> </a>
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
    <a href="{{ route('company-calendar.index') }}"><span><i data-feather="calendar"></i></span><span
            class="nav-label">Company Calendar</span></a>
</li>