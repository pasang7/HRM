@extends('layouts.layout')
@section('title', 'Allowances')

@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-0">Allowances</h5>
                                <small>Note: Changing status will reset all assigned employee state to
                                    none. </small>
                            </div>
                            <a href="{{ route('payroll-setting.income.create') }}" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary"
                                title="Create Allowance">
                                <i data-feather="plus"></i>Add Allowance
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-3 pt-1">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-bordered table-hover" cellspacing="0" width="100%" style="border: 0;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($incomes as $k => $income)
                                    <tr id={{ $k }}>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $income->name }} ({{ $income->short_name }})</td>
                                        <td>
                                            @if ($income->status == 'active')
                                                <a href="javascript:void(0)" status="active"
                                                    onclick="changeStatus({{ $income->id }})"><i
                                                        class="fa fa-circle text-success"> Active</i></a>
                                            @else
                                                <a href="javascript:void(0)" status="in_active"
                                                    onclick="changeStatus({{ $income->id }})"><i
                                                        class="fa fa-circle text-danger"> Inactive</i> </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($income->status == 'active')
                                                @if ($income->is_assign == 'no')
                                                    <a href="{{ route('payroll-setting.income.assign.form', $income->id) }}"
                                                        class="btn btn-sm btn-secondary" title="edit"><i
                                                            class="fa fa-user-plus"></i> Assign Employee</a>
                                                @else
                                                    <a href="{{ route('payroll-setting.income.assign.edit', $income->id) }}"
                                                        class="btn btn-sm btn-secondary" title="edit"><i
                                                            class="fa fa-user-plus"></i> Edit Assign Employee</a>
                                                @endif
                                            @endif
                                            <a href="{{ route('payroll-setting.income.edit', $income->id) }}"
                                                style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm ml-2" title="edit"><i data-feather="edit-2"></i>
                                                Edit</a>
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
@section('js')
    <script>
        function changeStatus(id) {
            var status = $(event.currentTarget).attr('status');
            $.ajax({
                    method: "GET",
                    url: '{{ route('payroll-setting.changeStatus') }}',
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
