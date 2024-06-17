@extends('layouts.layout')
@section('title', 'Assign Allowance')
@section('content')
    <form autocomplete="off" method="POST" action="{{ route('payroll-setting.edit.income.assign') }}">
        @csrf
        <input type="hidden" name="income_id" value="{{ $income->id }}" readonly>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header header-bg" style="--sec_header_color: {{ $settings->sec_header_color }};">
                            <p class="mb-0 fw-600">Assign {{ $income->title }}</p>
                        </div>
                        <div class="card-body bg-lgrey">
                            <div class="custom-form-wrapper">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="hdetails-wrapper">
                                            <div class="row">
                                                @if ($income->calculation_method == 'percent')
                                                    <div class="col-md-4 form-group">
                                                        <label>Percent Rate (%) of Basic Salary</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="number" name="percent_rate"
                                                            class="form-control custom-form-control"
                                                            aria-describedby="percent_rateHelp"
                                                            placeholder="Enter Percent Rate"
                                                            value="{{ $income->percent_rate }}">
                                                        @error('percent_rate')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                @else
                                                    <div class="col-md-4 form-group">
                                                        <label for="fixed_amount">Fixed Amount</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="number" name="fixed_amount"
                                                            class="form-control custom-form-control"
                                                            aria-describedby="amountHelp" placeholder="Enter Fixed Amount"
                                                            value="{{ $income->fixed_amount }}" readonly>
                                                        @error('fixed_amount')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                @endif
                                                <div class="col-md-4 form-group">
                                                    <label for="assign_status" class="required">Add to All
                                                        Employee?</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <select class="form-control custom-form-control" id="assign_status"
                                                        name="assign_status" onchange="changeAssign(this.value)">
                                                        <option value="partial"
                                                            {{ old('assign_status', isset($income->assign_status) ? $income->assign_status : '') == 'partial'? 'selected="selected"': '' }}>
                                                            No
                                                        </option>
                                                        <option value="all"
                                                            {{ old('assign_status', isset($income->assign_status) ? $income->assign_status : '') == 'all'? 'selected="selected"': '' }}>
                                                            Yes
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row" id="userListDiv">
                                                <div class="col-md-12 form-group">
                                                    <label for="fixed_amount">Choose Employee to Assign Allowance</label>
                                                </div>
                                                @foreach ($staffs as $staff)
                                                    <div class="col-md-4" style="padding-bottom:10px;">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="{{ $staff->id }}" id="{{ $staff->slug }}"
                                                                name="user_id[]"
                                                                @if (in_array($staff->id, $selectedStaffIds)) checked @endif
                                                                incomeId="{{ $income->id }}"
                                                                onclick="showAllowance(this.value)">
                                                            <label class="form-check-label" for="{{ $staff->slug }}">
                                                                {{ $staff->name }}
                                                            </label>
                                                        </div>
                                                        @if (in_array($staff->id, $selectedStaffIds))
                                                            <div id="allowanceDiv{{ $staff->id }}">
                                                                <input type="text" style="margin-top:10px; "
                                                                    name="staff_allowance[{{ $staff->id }}]"
                                                                    class="form-control"
                                                                    value="{{ $staffAllow[$staff->id] }}">
                                                            </div>
                                                        @else
                                                            <div id="allowanceDiv{{ $staff->id }}"
                                                                style="display: none;"> </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-create-wrapper">
                                    <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm btn-create">Assign</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script>
        const selectedEmployee = "{{ route('payroll-setting.staff.selection') }}"
        const unselectedEmployee = "{{ route('payroll-setting.staff.deselection') }}"
    </script>
    <script type="text/javascript" src="{{ asset('js/payroll_income.js') }}"></script>
@endsection
@section('css')
    <style type="text/css">
        .required:after {
            content: " *";
            color: red;
        }

    </style>
@endsection
