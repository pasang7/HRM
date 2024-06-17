@extends('layouts.layout')
@section('title', 'Department')

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
                            <h5 class="mb-0">Department</h5>
                            <a href="{{ route('department.create') }} " title=" Create Project"
                                style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm"><i data-feather="plus"></i>Add Department</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-3 pt-1">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Shift</th>
                                    <th scope="col">Holiday</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $department)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $department->name }}</td>
                                        <td class="shftListLoop">
                                            <ul>
                                                @foreach ($department->shifts as $shift)
                                                    <li>
                                                        <strong>Starts From:</strong> {{ date('h:i A', strtotime($shift->clockin)) }}
                                                        &nbsp;
                                                        <strong>Ends At:</strong> {{ date('h:i A', strtotime($shift->clockout)) }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            @forelse ($department->holidays as $holiday)
                                            {{ $days_name[$holiday->day] }}
                                            @empty
                                                Not Defined
                                            @endforelse
                                        </td>
                                        <td>
                                            <!-- <a href="{{ route('department.edit', $department->slug) }}" data-id="{{ $department->id }}" class="btn btn-success btn-sm btn-edit">Edit</a> -->
                                            <a href="#" data-id="{{ $department->id }}"
                                                style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm btn-change-holiday" class="btn btn-primary btn-sm" style="--main_header_color : {{ $settings->main_header_color }};">
                                                <i data-feather="refresh-cw" class="mr-1"></i>Change Holiday</a>
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

@endsection

@section('modals')
    <div class="modal fade" id="modal-change-holiday" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="changeHolidayLabel" aria-hidden="true">
    </div>
@endsection

@section('js')
    <script>
        $(document).on('click', '.btn-change-holiday', function(e) {
            e.preventDefault()
            var id = $(this).data('id')
            $.ajax({
                    url: "{{ route('department.get-change-holiday-form') }}",
                    method: "POST",
                    data: {
                        'department_id': id
                    },
                    beforeSend: function(xhr) {

                    }
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
                    beforeSend: function(xhr) {

                    }
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
@endsection
