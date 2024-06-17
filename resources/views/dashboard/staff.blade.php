<div class="hrProFlexGrp">
    <div class="hrDashboardData">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 mb-1">
                    <div class="hrproTableHead">
                        <h5>Today's Attendance</h5>
                    </div>
                </div>
                @if ($clockedIn)
                    <div class="col-lg-6 pr-2">
                        <div class="newHrDashCard presentBg">
                            <div class="dashHrInfo">
                                <h6 class="text-success">Clock In</h6>
                                <h2 class="text-success">
                                    {{ $clock_in ? date('g:i a', strtotime($clock_in)) : 'N/A' }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 pl-2">
                        <div class="newHrDashCard absentBg">
                            <div class="dashHrInfo">
                                <h6 class="text-danger">Clock Out</h6>
                                <h2 class="text-danger">
                                    {{ $clock_out ? date('g:i a', strtotime($clock_out)) : 'N/A' }}
                                </h2>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12 pl-2">
                        <div class="newHrDashCard absentBg">
                            <div class="dashHrInfo">
                                <h6 class="text-danger text-center">
                                    You have not clocked in today!
                                </h6>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-lg-12  mt-1">
                    <div class="hrproTableHead mt-2">
                        <h5>Leave Report</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table  table-sm" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Yearly</th>
                                    <th>Taken</th>
                                    <th>Available</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_leave_types as $user_leave_type)
                                    <tr>
                                        <td>{{ $user_leave_type['name'] }}</td>
                                        <td>{{ $user_leave_type['yearly'] }}</td>
                                        <td>{{ $user_leave_type['taken'] }}</td>
                                        <td>{{ $user_leave_type['available'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
                <div class="col-lg-12  mt-1">
                    <div class="hrproTableHead mt-2">
                        <h5>Travel Report</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table  table-sm" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Program</th>
                                    <th class="text-center">Reviewed</th>
                                    <th class="text-center">Approved</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($travelReports as $travelReport)
                                    <tr>
                                        <td>{{ $travelReport['program_name'] }}</td>
                                        <td class="text-center">
                                            @if ($travelReport['is_reviewed'])
                                                <i class="fa fa-check text-success"></i>
                                            @else
                                                <i class="fa fa-times text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($travelReport['is_accepted'])
                                                <i class="fa fa-check text-success"></i>
                                            @else
                                                <i class="fa fa-times text-danger"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="hrProRightSummary" style="margin-top: 30px;background-color: #f1f1f1;">
        <div class="staffButtonGrp">
            <div class="d-flex align-items-center  justify-content-end">
                <div class="d-flex align-items-center  recButon">
                    <a href="{{ route('report.my-report') }}"
                       class="btn btn-secondary btn-sm d-flex align-items-center mr-2" style="--main_header_color : {{ $settings->main_header_color }};"><i class="fa fa-file mr-1"></i>Report
                        History</a>
                    <a href="{{ route('report.create') }}"
                        class="btn btn-primary btn-sm d-flex align-items-center " style="--main_header_color : {{ $settings->main_header_color }};"><i
                            class="fa fa-paper-plane mr-1"></i>Send Report</a>


                </div>
            </div>
        </div>
        <div class="createTaskGrp pb-1" style="margin-top: 15px;background-color: #f1f1f1;">
            <h5 class="mb-4">Task List</h5>
            <form action="{{ route('task.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="row no-gutters">
                            @if (Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3 || Auth::user()->role == 4)
                                <div class="col-lg-12 mb-3 col-md-12 col-sm-12 col-xs-12">
                                    <label>Date</label>
                                    <div class="margin-1 custom-form-group custom-select-wrapper">
                                        <select class="form-control custom-select" name="user_id" required>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                            @endif
                            <div class="col-lg-12 mb-3 col-md-12 col-sm-12 col-xs-12">
                                <label>Date</label>
                                <div class="margin-1 custom-form-group">
                                    <input type='text' name="deadline" class="form-control single-date" required />
                                </div>
                            </div>

                            <div class="col-lg-12 mb-3 col-md-12 col-sm-12 col-xs-12">
                                <div class="margin-1 custom-form-group custom-select-wrapper">
                                    <label>Priority</label>
                                    <select name="priority" class="form-control custom-select" required>
                                        <option value="0">Low</option>
                                        <option value="01">Normal</option>
                                        <option value="10">High</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="margin-1 custom-form-group">
                                    <label>Task</label>
                                    <textarea name="task" class="form-control" placeholder="Add new task" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button class="btn  btn-success btn-add-tasks btn-sm" type="submit"><i
                                class="fa fa-plus"></i>Add</button>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        @if (count($my_tasks) > 0)
            <div class="taskListGrp pt-1">
                <h5> Your Remaining Tasks </h5>
                @foreach ($my_tasks as $task)
                    <div class="taskListCard task" data-id="{{ $task->id }}">
                        <div class="d-flex align-items-start justify-content-between">
                            <h6>{{ $task->task }}</h6>
                            <a href="" title="Remove Task">
                                <div class="removeIcon">
                                    <button type="button" class="btn btn-icon btn-sm btn-remove-task"
                                        title="Remove Task">
                                        <i data-feather="x"></i>
                                    </button>

                                </div>
                            </a>
                        </div>

                        <div class="d-flex align-items-center calendarIcon mt-2 mb-2 pb-1 ">
                            <i data-feather=" user" class="mr-1"></i>
                            <p>Assigned By: {{ $task->creator->name }} </p>

                        </div>

                        @if ($task->priority == '0')
                            <div class="d-flex align-items-center calendarIcon mt-2 mb-2 pb-1 " title="Priority : Low">
                                <i data-feather="eye" class="mr-1"></i>
                                <p>Low</p>

                            </div>
                        @elseif($task->priority == '01')
                            <div class="d-flex align-items-center calendarIcon mt-2 mb-2 pb-1 "
                                title="Priority : Normal">
                                <i data-feather="eye" class="mr-1"></i>
                                <p>Normal</p>

                            </div>
                        @else
                            <div class="d-flex align-items-center calendarIcon mt-2 mb-2 pb-1 " title="Priority : High">
                                <i data-feather="eye" class="mr-1"></i>
                                <p>High</p>
                            </div>
                        @endif

                        <div class="d-flex align-items-center calendarIcon mt-2 ">
                            <i data-feather="calendar" class="mr-1"></i>
                            <p> {{ $task->deadline->format('d M, Y') }}</p>

                        </div>
                        @if (!$task->is_complete)
                            <div class="mb-1 mt-2 pt-2">
                                <button type="button" class="btn-complete btn-mark-complete" title="Mark Complete">
                                    <i data-feather="check"></i> Mark As Complete
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
{{-- <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
    <div class="row margin-bottom-2">
        <div class="col-lg-6 col-sm-12 margin-bottom-2">
            <div class="card-header header-bg col-md-12 margin-bottom-2"
                style="--sec_header_color: {{ $settings->sec_header_color }};">
                <p class="mb-0">
                    <span>Today's Attendance</span>
                </p>
            </div>
            <div class="col-12 bg-light ">
                <div class="row justify-content-center">
                    @if ($clockedIn)
                        <div class="col-lg-6 col-12">
                            <div class="card bg-light pt-4 pb-4">
                                <div class="text-center bd-card-info">
                                    <h4 class="font-weight-semibold text-success">
                                        Clock In
                                        <i class="fa fa-clock-o"></i>
                                    </h4>
                                    <h5 class="fw-600 text-success">{{ date('g:i a', strtotime($clock_in)) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="card bg-light pt-4 pb-4">
                                <div class="text-center bd-card-info">
                                    <h4 class="font-weight-semibold text-danger">
                                        Clock Out
                                        <i class="fa fa-clock-o"></i>
                                    </h4>
                                    <h5 class="fw-600 text-danger">
                                        {{ $clock_out ? date('g:i a', strtotime($clock_out)) : '-' }}</h5>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card bg-light pt-4 pb-4">
                            <div class="bd-card-info">
                                <p>You haven't clocked in today</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 margin-bottom-2">
            <div class="card-header header-bg col-md-12 margin-bottom-2"
                style="--sec_header_color: {{ $settings->sec_header_color }};">
                <p class="mb-0">
                    <span>Report List</span>
                </p>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 col-12">
                    <a href="{{ route('report.create') }}">
                        <div class="card bg-light pt-4 pb-4">
                            <div class="text-center bd-card-info">
                                <i class="fa fa-paper-plane fa-3x rounded-round pb-1"></i>
                                <h6 class="m-0 font-weight-semibold">Send Report
                                </h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 col-12">
                    <a href="{{ route('report.my-report') }}">
                        <div class="card bg-light pt-4 pb-4">
                            <div class="text-center bd-card-info">
                                <i class="fa fa-file fa-3x rounded-round pb-1"></i>
                                <h6 class="m-0 font-weight-semibold">Report History
                                </h6>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-sm-12 margin-bottom-2">
            <div class="card-header header-bg col-md-12 margin-bottom-2"
                style="--sec_header_color: {{ $settings->sec_header_color }};">
                <p class="mb-0">
                    <span>Leave Report</span>
                </p>
            </div>
            <div class="col-12 bg-light ">
                <div class="row">
                    <table class="table  table-sm" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Yearly</th>
                                <th>Taken</th>
                                <th>Available</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user_leave_types as $user_leave_type)
                                <tr>
                                    <td>{{ $user_leave_type['name'] }}</td>
                                    <td>{{ $user_leave_type['yearly'] }}</td>
                                    <td>{{ $user_leave_type['taken'] }}</td>
                                    <td>{{ $user_leave_type['available'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-sm-12 margin-bottom-2">
            <div class="card-header header-bg col-md-12 margin-bottom-2"
                style="--sec_header_color: {{ $settings->sec_header_color }};">
                <p class="mb-0">
                    <span>Travel Report</span>
                </p>
            </div>
            <div class="col-12 bg-light ">
                <div class="row">
                    <table class="table  table-sm" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Program</th>
                                <th class="text-center">Reviewed</th>
                                <th class="text-center">Approved</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($travelReports as $travelReport)
                                <tr>
                                    <td>{{ $travelReport['program_name'] }}</td>
                                    <td class="text-center">
                                        @if ($travelReport['is_reviewed'])
                                            <i class="fa fa-check text-success"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($travelReport['is_accepted'])
                                            <i class="fa fa-check text-success"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}



{{-- <div class="col-md-4 col-sm-12">
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-12">
                    <div class="card margin-bottom-2">
                        <div class="card-header to-do-title header-bg"
                            style="--sec_header_color: {{ $settings->sec_header_color }};">
                            <p class="fw-600 mb-0">
                                <span>Task List</span>
                                <span class="count">( 0 )</span>
                            </p>
                        </div>
                        <div class="card-body to-do-details bg-lgrey">

                        </div>
                    </div>
                </div>
                @if (count($my_tasks) > 0)
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="pull-left">
                                    <p class="fw-600 list-title">Your list</p>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-sm clear-completed"
                                        href="{{ route('task.clear.completed') }}">
                                        <i class="fa fa-check"></i> Clear Completed
                                    </a>
                                    <a class="btn btn-sm clear-all" href="{{ route('task.clear.all') }}">
                                        <i class="fa fa-trash"></i> Clear All
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($my_tasks as $task)
                                <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12 task"
                                    data-id="{{ $task->id }}">
                                    <div class="row margin-bottom-2">
                                        <div class="col-md-9">
                                            <h6 class="fw-600">{{ $task->task }} @if ($task->is_complete)
                                                    <i class="fa fa-check-circle text-success" title="completed"></i>
                                                @endif
                                            </h6>
                                            @if ($task->priority == '0')
                                                <span class="badge text-light priority-status low">Priority: Low</span>
                                            @elseif($task->priority == '01')
                                                <span class="badge text-light priority-status normal">Priority:
                                                    Normal</span>
                                            @else
                                                <span class="badge text-light priority-status high">Priority:
                                                    High</span>
                                            @endif
                                            @if ($task->assigned_by != Auth::user()->id)
                                                <p class="mb-0">Assigned by: {{ $task->creator->name }}
                                                </p>
                                            @endif
                                            <i class="fa fa-clock-o"></i> {{ $task->deadline->format('d M, Y') }}

                                        </div>
                                        <div class="col-md-3">
                                            @if (!$task->is_complete)
                                                <button type="button" class="btn btn-icon btn-sm btn-mark-complete"
                                                    title="Mark Complete">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            @endif
                                            @if ($task->user_id == $task->assigned_by)
                                                <button type="button" class="btn btn-icon btn-sm btn-remove-task"
                                                    title="Remove Task">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endif

                                        </div>
                                    </div>
                                    <hr style="width:100%;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div> --}}
