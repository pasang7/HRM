<div class="hrProFlexGrp">
    <div class="hrDashboardData">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 margin-bottom-2 pr-0">
                    <a href="{{ route('project.index') }}">
                        <div class="newHrDashCard">
                            <div class="d-flex align-items-center">
                                <div class="dashHrIcon">
                                    <img src="{{ asset('theme/images/project.png') }}" alt="">
                                </div>
                                <div class="dashHrInfo">
                                    <h6>Projects</h6>
                                    <h2>{{ $projects->count() }}</h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 margin-bottom-2 pr-0">
                    <a href="{{ route('leave.index') }}">
                        <div class="newHrDashCard">
                            <div class="d-flex align-items-center">
                                <div class="dashHrIcon">
                                    <img src="{{ asset('theme/images/leave.png') }}" alt="">
                                </div>
                                <div class="dashHrInfo">
                                    <h6>Leave Request</h6>
                                    <h2>{{ \App\Helpers\Helper::calculateLeaveRequest() ? \App\Helpers\Helper::calculateLeaveRequest() : '0' }}</h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 margin-bottom-2">
                    <a href="{{ route('travel.review') }}">
                        <div class="newHrDashCard">
                            <div class="d-flex align-items-center">
                                <div class="dashHrIcon">
                                    <img src="{{ asset('theme/images/travel.png') }}" alt="">
                                </div>
                                <div class="dashHrInfo">
                                    <h6>Travel Request</h6>
                                    <h2>{{ \App\Helpers\Helper::calculateTravelRequest() ? \App\Helpers\Helper::calculateTravelRequest() : '0' }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-4">
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
        <div class="col-lg-12 mb-4 mt-1">
            <div class="hrproTableHead mt-2">
                <h5>Assigned Task Records</h5>
            </div>
            @if (count($assigned_tasks) > 0)
                <div class="table-responsive" style="--main_header_color : {{ $settings->main_header_color }};">
                    <table class="table table-border">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Task</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">Deadline</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assigned_tasks as $t => $task)
                                <tr>
                                    <th scope="row">{{ $t + 1 }}</th>
                                    <td>
                                        @php $task_name = wordwrap($task->task,25,"<br>\n"); @endphp
                                        @php echo $task_name @endphp
                                    </td>
                                    <td>
                                        @php $assigned_to = wordwrap($task->assignedUser->name,10,"<br>\n"); @endphp
                                        @php echo $assigned_to @endphp
                                    </td>
                                    <td>{{ date('d M, Y', strtotime($task->deadline)) }}</td>
                                    <td>
                                        @if ($task->priority == 0)
                                            Low
                                        @elseif($task->priority == 1)
                                            Normal
                                        @else
                                            High
                                        @endif
                                    </td>
                                    <td>
                                        @if ($task->is_complete)
                                            <span class="badge badge-success"> Completed</span>
                                        @else
                                            <span class="badge badge-info"> Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="col-lg-12">
            <div class="hrproTableHead">
                <h5>Project Deadline</h5>
            </div>
            <div class="table-responsive" style="--main_header_color : {{ $settings->main_header_color }};">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th scope="col">S.No.</th>
                            <th scope="col" class="w-50">Project</th>
                            <th scope="col">Deadline</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $p => $project)
                            <tr>
                                <th scope="row">{{ $p + 1 }}</th>
                                <td>
                                    @php $project_name = wordwrap($project->name,20,"<br>\n"); @endphp
                                    @php echo $project_name @endphp
                                </td>
                                <td>{{ date('d M, Y', strtotime($project->deadline)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="hrProRightSummary" style="background-color: #f1f1f1;">
        <div class="createTaskGrp pb-1">
            <h5>Create Task</h5>
            <form action="{{ route('task.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        @if (Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3 || Auth::user()->role == 4)
                            <label>Assigned To</label>
                            <select class="custom-select" name="user_id" required>
                                <option value="">Select Employee</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                @else
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                    @endif
                    <div class="col-lg-12 mb-3">
                        <label>Deadline</label>
                        <input type='text' id="end_to" name="deadline" class="form-control" required />
                    </div>
                    <div class="col-lg-12 mb-3">
                        <label>Priority</label>
                        <select name="priority" class="custom-select" required>
                            <option value="0">Low</option>
                            <option value="01">Normal</option>
                            <option value="10">High</option>
                        </select>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <label>Task</label>
                        <textarea name="task" class="form-control" placeholder="Add new task" rows="3" required></textarea>
                    </div>
                    <div class="col-lg-12">
                        <div class="d-flex align-items-center justify-content-end">
                            <button style="--main_header_color : {{ $settings->main_header_color }};"
                                class="btn btn-primary btn-sm btn-add-tasks" type="submit">
                                <i data-feather="plus"></i>Add Now
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        {{-- new task list starts here --}}
        <div class="taskListGrp pt-1">
            <h5> Your Remaining Tasks </h5>
            @foreach ($my_tasks as $task)
                <div class="taskListCard task" data-id="{{ $task->id }}">
                    <div class="d-flex align-items-start justify-content-between">
                        <h6>{{ $task->task }}</h6>
                        <a href="" title="Remove Task">
                            <div class="removeIcon">
                                <button type="button" class="btn btn-icon btn-sm btn-remove-task" title="Remove Task">
                                    <i data-feather="x"></i>
                                </button>

                            </div>
                        </a>
                    </div>
                    @if ($task->assigned_by != Auth::user()->id)
                        <div class="d-flex align-items-center calendarIcon mt-2 mb-2 pb-1 " ">
                            <i data-feather=" user" class="mr-1"></i>
                            <p>Assigned By: {{ $task->creator->name }}</p>

                        </div>
                    @endif
                    @if ($task->priority == '0')
                        <div class="d-flex align-items-center calendarIcon mt-2 mb-2 pb-1 " title="Priority : Low">
                            <i data-feather="eye" class="mr-1"></i>
                            <p>Low</p>

                        </div>
                    @elseif($task->priority == '01')
                        <div class="d-flex align-items-center calendarIcon mt-2 mb-2 pb-1 " title="Priority : Normal">
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
                        <p>{{ $task->deadline->format('Y-m-d') }}</p>

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
            <div class="d-flex align-items-center justify-content-end">
                <div class="d-flex align-items-center">
                    <a class="btn btn-sm btn-success clear-completed" href="{{ route('task.clear.completed') }}">
                        <i data-feather="check"></i> Clear Completed
                    </a>
                    <a class="btn btn-sm btn-danger clear-all ml-2" href="{{ route('task.clear.all') }}">
                        <i data-feather="trash-2"></i> Clear All
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-3">

            @include('dashboard.chart_components.holidayBirthday')
        </div>
        {{-- new task list ends here --}}
    </div>
</div>
