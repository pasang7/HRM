@extends('layouts.layout')
@section('title', 'Designation')

@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Designation</h5>
                            <a href="javascript:0;" title="Create Project" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#designationCreateModal"><i data-feather="plus"></i>Add Designation</a>
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
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($designations as $k => $designation)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $designation->name }}</td>
                                        <td>
                                            <!-- <span class="badge badge-success"> Completed</span> -->

                                            {!! $designation->designation_status !!}
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm "
                                                data-toggle="modal" 
                                                data-target="#designationEditModal-{{ $k }}"><i
                                                    data-feather="edit-2"></i> Edit</a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="designationEditModal-{{ $k }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="designationEditModal-{{ $k }}Label"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="designationEditModal-{{ $k }}Label">Edit
                                                                Designation</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('designation.update', $designation->id) }}"
                                                            method="POST" autocomplete="off">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row form-group">
                                                                    <div class="col-lg-12">
                                                                        <label for="name"
                                                                            class="required">Name</label>
                                                                        <input id="name" type="text"
                                                                            class="form-control custom-form-control"
                                                                            name="name" placeholder="Designation Name"
                                                                            value="{{ $designation->name }}" required=""
                                                                            autofocus="">
                                                                    </div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <label for="name"
                                                                            class=" required">Status</label>
                                                                        <select class="form-control custom-form-control"
                                                                            name="is_active">
                                                                            <option value="yes"
                                                                                {{ old('is_active', isset($designation->is_active) ? $designation->is_active : '') == 'yes'? 'selected="selected"': '' }}>
                                                                                Active</option>
                                                                            <option value="no"
                                                                                {{ old('is_active', isset($designation->is_active) ? $designation->is_active : '') == 'no'? 'selected="selected"': '' }}>
                                                                                Inactive</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm"><i
                                                                        data-feather="check"></i>Update</button>
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="designationCreateModal" tabindex="-1" role="dialog"
        aria-labelledby="designationCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="designationCreateModalLabel">Create Designation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('designation.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label for="name" class="required">Name</label>
                                <input id="name" type="text" class="form-control custom-form-control" name="name"
                                    placeholder="Designation Name" required="" autofocus="">
                                @if ($errors->has('name'))
                                    <div class="text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="name" class=" required">Status</label>
                                <select class="form-control custom-form-control" name="is_active">
                                    <option value="yes">Active</option>
                                    <option value="no">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm"><i data-feather="check"></i>Create Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <style type="text/css">
        .required:after {
            content: " *";
            color: red;
        }

    </style>
@endsection
@section('js')
    <script>
        function changeStatus(id) {
            var status = $(event.currentTarget).attr('status');
            $.ajax({
                    method: "GET",
                    url: '{{ route('designation.changeStatus') }}',
                    data: {
                        id: id,
                        status: status,
                    }
                })
                .done(function(res) {
                    if (res == 1) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Status Changed',
                            type: 'info',
                            icon: "success",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })
                        location.reload();
                    }
                })
        }
    </script>
@endsection
