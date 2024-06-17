@extends('layouts.layout')
@section('title', 'Payroll Generator')

@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Salary Sheet List</h5>
                            <a href="javascript:void(0);" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm" title="Generate New"
                                data-toggle="modal" data-target="#sheetCreateModal">
                                <i class="fa fa-plus"></i> Generate Salary Sheet
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-3 pt-1">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Payroll Report of</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payroll_histories as $k => $payroll)
                                    @php
                                        $duration = now()->format('d') . '-' . $payroll->month . '-' . $payroll->year;
                                    @endphp
                                    <tr id={{ $k }}>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ date('M, Y', strtotime($duration)) }}</td>
                                        <td>
                                            <a href="{{ route('salary.sheet.report', $payroll->id) }}"
                                                style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm"><i data-feather="eye"></i>View Salary
                                                Sheet</a>
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
    <div class="modal fade" id="sheetCreateModal" tabindex="-1" role="dialog" aria-labelledby="sheetCreateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sheetCreateModalLabel">Generate Sheet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('salary.generator') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        @if ($setting->payroll_calendar_type == 'english')
                            <div class="row form-group">
                                <label for="year"
                                    class="col-lg-3 col-md-3 col-sm-3 col-xs-12 col-form-label required">Select Year</label>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <select class="form-control custom-form-control" name="year">
                                        <option value="{{ $current_year }}">{{ $current_year }}</option>
                                        <option value="{{ $prev_year }}">{{ $prev_year }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="month"
                                    class="col-lg-3 col-md-3 col-sm-3 col-xs-12 col-form-label required">Select
                                    Month</label>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <select class="form-control custom-form-control" name="month">
                                        @foreach (\App\Helpers\Helper::getEngMonths() as $month)
                                            <option value="{{ $month->value }}"
                                                {{ \Carbon\Carbon::now()->format('m') == $month->value ? 'selected="selected"' : '' }}>
                                                {{ $month->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    </div>
                @else
                    @endif
                    <div class="modal-footer">
                        <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm me-2" data-dismiss="modal">Close</button>
                        <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
@endsection
