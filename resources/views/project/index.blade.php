@extends('layouts.layout')
@section('title', 'Project')

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
                            <h5 class="mb-0">Projects</h5>
                            <a href="{{ route('project.create') }}" title="Create Project"
                                style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm"><i data-feather="plus"></i>Create Project</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-3 pt-1">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Deadline</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            @php
                                            $title=wordwrap($project->name,35,"<br />\n", false);
                                        @endphp
                                        @php echo "$title" @endphp</td>
                                        @if ($project->is_other)
                                            <td></td>
                                            <td></td>
                                        @else
                                            <td>{{ $project->department->name }}</td>
                                            <td>{{ $project->created_at->format('Y/m/d') }}</td>
                                        @endif
                                        <td>
                                            @if ($project->is_other)
                                            @else
                                                @if ($project->status)
                                                <span class="badge badge-success">

                                                    Completed
                                                </span>
                                                @else
                                                    <div class="actionBtn">
                                                        <a href="{{ route('project.edit', $project->slug) }}"
                                                        style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm"
                                                            data-id="{{ $project->id }}"><i data-feather="edit-2" class="me-1"> </i>Edit</a>
                                                        <a href="{{ route('project.mark-complete', $project->slug) }}"
                                                            class="btn-primary btn btn-sm" data-id="{{ $project->id }}"><i
                                                                data-feather="check" ></i>Mark As
                                                            Complete</a>
                                                    </div>
                                                @endif
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
                    url: "{{ route('user.get-change-holiday-form') }}",
                    method: "POST",
                    data: {
                        'user_id': id
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
