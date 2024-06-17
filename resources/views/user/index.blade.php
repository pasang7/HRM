@extends('layouts.layout')
@section('title', 'Employee')
@section('content')
    @php
    $days_name = ['Sun', 'Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat'];
    @endphp
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Employees</h5>
                            <a href="{{ route('user.create') }} " title=" Create Project" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm"><i
                                    data-feather="plus"></i>Add Employee</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-2 pt-1">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-user table-hover" style="width:100%;">
                            <thead>
                                <tr>
                                    <th scope="col">EID</th>
                                    <th scope="col">Name</th>
                                    {{-- <th scope="col">Gender</th> --}}
                                    {{-- <th scope="col">Email</th> --}}
                                    {{-- <th scope="col">Address</th> --}}
                                    <th scope="col">Department</th>
                                    {{-- <th scope="col">Designation</th> --}}
                                    <th scope="col">Indv. Holiday</th>
                                    <th scope="col">Salary</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $u => $user)
                                    <tr>
                                        {{-- <th scope="row">{{ $u + 1 }}</th> --}}
                                        <td>{{ $user->employee_id }}</td>
                                        <td class="text-capitalize">{{ $user->name }}
                                            ({{ $user->gender == 0 ? 'F' : 'M' }})
                                            <br>
                                            <strong>Designation: </strong>{{ $user->userDesignation->name }}
                                        </td>
                                        {{-- <td>{{ $user->gender == 0 ? 'F' : 'M' }}</td> --}}
                                        {{-- <td>{{ $user->email }}</td> --}}
                                        {{-- <td>{{ $user->address }}</td> --}}
                                        <td>{{ $user->department->name }} <br>
                                            <strong>Role: </strong>{{ $user->userRole->name }}
                                        </td>
                                        {{-- <td>{{ $user->userDesignation->name }}</td> --}}
                                        <td>
                                            @forelse ($user->holidays as $holiday)
                                                {{ $days_name[$holiday->day] }}
                                            @empty
                                                Not Defined
                                            @endforelse 
                                        </td>
                                        <td>
                                            @if ($user->current_salary)
                                                {{ $user->current_salary->salary }}
                                        </td>
                                    @else
                                        -
                                @endif
                                <td>
                                    <a href="{{ route('user.edit', $user->slug) }}" data-id="{{ $user->id }}"
                                        title="edit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm mr-1">Edit</a>
                                    <a href="{{ route('user.view', $user->id) }}" title="view"
                                        style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm mr-1">View</a>
                                    @if ($user->is_deleted)
                                        <a href="{{ route('user.undo.delete', $user->slug) }}"
                                            style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm mr-1" data-id="{{ $user->id }}"
                                            title="undo delete"
                                            onclick="return confirm('Are you sure to activate this user?')">Refresh</a>
                                    @else
                                        <a href="{{ route('user.delete', $user->slug) }}" data-id="{{ $user->id }}"
                                            style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm mr-1" title="delete"
                                            onclick="return confirm('Are you sure to delete this user?')">Delete</a>
                                    @endif
                                    <a href="#" data-id="{{ $user->id }}"
                                        style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm mr-1 btn-change-holiday">Change Holiday</a>
                                    {{-- <a href="#" data-id="{{ $user->id }}"
                                        style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm mr-1 btn-user-leave-report">Leave Report</a> --}}
                                    @if (Auth::user()->role == 1)
                                        <a href="#" data-id="{{ $user->id }}" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm"
                                            data-toggle="modal" data-target="#changeSalary-{{ $u }}">Increase
                                            Salary</a>
                                    @endif
                                    <!-- Modal -->
                                    <div class="modal fade" id="changeSalary-{{ $u }}" tabindex="-1"
                                        role="dialog" aria-labelledby="changeSalary-{{ $u }}Label"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="changeSalary-{{ $u }}Label">
                                                        Update Salary</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('user.update.salary') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Current Salary</label>
                                                            <input type="number"
                                                                class="form-control custom-form-control employee_salary"
                                                                aria-describedby="salaryHelp" min="1"
                                                                value="{{ $user->current_salary->salary }}" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="salary">Salary in Amount</label>
                                                            <input type="text" name="salary"
                                                                class="form-control custom-form-control salary_amount"
                                                                aria-describedby="salaryHelp" placeholder="Salary" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="salary_percent">Salary in
                                                                Percent</label>
                                                            <input type="text" name="salary_percent"
                                                                class="form-control custom-form-control salary_percentage"
                                                                placeholder="Salary Percentwise">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Updated From Date</label>
                                                            <input name="starting" type="text" id="start_from"
                                                                class="form-control custom-form-control"
                                                                placeholder="Updated From" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="javascript:void(0);" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</a>
                                                        <button type="submit" class="btn btn-success">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('modals')
        <div class="modal fade" id="modal-change-holiday" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="changeHolidayLabel" aria-hidden="true"></div>
    @endsection
    @section('js')
        <script src="{{ asset('js/update_salary.js') }}"></script>
        <script>
            const get_change_holiday_form_url = "{{ route('user.get-change-holiday-form') }}";
            const get_leave_report_url = "{{ route('user.get.leave.report') }}";
            const change_salary_url = "{{ route('user.get-change-salary-form') }}";
        </script>
        <script>
            $(document).on('click', '.btn-change-holiday', function(e) {
                e.preventDefault()
                var id = $(this).data('id')
                $.ajax({
                        url: get_change_holiday_form_url,
                        method: "POST",
                        data: {
                            'user_id': id
                        },
                        beforeSend: function(xhr) {}
                    })
                    .done(function(data) {
                        var res = JSON.parse(data)
                        if (res.status) {
                            $('#modal-change-holiday').html(res.view)
                            $('#modal-change-holiday').modal('show')
                        } else {
                            alert(res.message)
                        }
                    });
            })
            $(document).on('submit', '#form-change-holiday', function(e) {
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
                            $('#modal-change-holiday').modal('hide')
                        } else {
                            alert(res.message)
                        }
                    });
            })

            $(document).on('submit', '#form-change-salary', function(e) {
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
                            $('#modal-change-holiday').modal('hide')
                        } else {
                            alert(res.message)
                        }
                    });
            })
        </script>
        <script>
            $(document).ready(function() {
                $('table').DataTable({
                    responsive: true,
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [20, 30, 50, -1],
                        ['20 rows', '30 rows', '50 rows', 'Show all']
                    ],
                    buttons: [
                        'pageLength',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                });
            });
        </script>
        <script>
            $(document).on('click', '.btn-user-leave-report', function(e) {
                e.preventDefault()
                var id = $(this).data('id')
                $.ajax({
                        url: get_leave_report_url,
                        method: "POST",
                        data: {
                            'user_id': id
                        },
                        beforeSend: function(xhr) {}
                    })
                    .done(function(data) {
                        var res = JSON.parse(data)
                        if (res.status) {
                            $('#modal-change-holiday').html(res.view)
                            $('#modal-change-holiday').modal('show')
                        } else {
                            showAlert('error', res.title, res.text)
                        }
                    });
            })
            $(document).on('click', '.btn-user-change-salary', function(e) {
                e.preventDefault()
                var id = $(this).data('id')
                $.ajax({
                        url: change_salary_url,
                        method: "POST",
                        data: {
                            'user_id': id
                        },
                        beforeSend: function(xhr) {}
                    })
                    .done(function(data) {
                        var res = JSON.parse(data)
                        if (res.status) {
                            $('#modal-change-holiday').html(res.view)
                            $('#modal-change-holiday').modal('show')
                        } else {
                            showAlert('error', res.title, res.text)
                        }
                    });
            })
        </script>
    @endsection
