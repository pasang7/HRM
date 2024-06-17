@extends('layouts.layout')
@section('title', 'Income')
@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Update Allowance</h5>
                    </div>
                </div>
                <div class="col-lg-12 mt-2">
                    <form autocomplete="off" method="POST" action="{{ route('payroll-setting.income.update') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="card">

                            <div class="card-body bg-lgrey">
                                <div class="custom-form-wrapper">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="hdetails-wrapper">
                                                <div class="row">
                                                    <div class="col-lg-6 form-group">

                                                        <label for="name" class="required">Title</label>

                                                        <input type="hidden" name="id" value="{{ $income->id }}" readonly>
                                                        <input type="text" name="name"
                                                            class="form-control custom-form-control"
                                                            aria-describedby="nameHelp" placeholder="Enter Allowance Title"
                                                            value="{{ $income->name }}">
                                                        @error('name')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror

                                                    </div>
                                                    <div class="col-lg-6 form-group">

                                                        <label for="short_name">Short Name</label>

                                                        <input type="text" name="short_name"
                                                            class="form-control custom-form-control"
                                                            aria-describedby="short_nameHelp" placeholder="Enter Short Name"
                                                            value="{{ $income->short_name }}">
                                                        @error('short_name')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror

                                                    </div>
                                                    <div class="col-12 form-group">

                                                        <label for="remarks">Remarks</label>

                                                        <textarea class="form-control custom-form-control" name="remarks">{{ $income->remarks }}</textarea>

                                                    </div>
                                                    <div class="col-lg-4 form-group">

                                                        <label for="calculation_method" class="required">Calculation
                                                            Method</label>

                                                        <select class="form-control custom-form-control"
                                                            id="calculation_method" name="calculation_method"
                                                            onchange="percentRate(this.value)">
                                                            <option value="">Calculation Method</option>
                                                            <option value="percent"
                                                                {{ old('calculation_method', isset($income->calculation_method) ? $income->calculation_method : '') == 'percent'? 'selected="selected"': '' }}>
                                                                Percent-wise</option>
                                                            <option value="amount"
                                                                {{ old('calculation_method', isset($income->calculation_method) ? $income->calculation_method : '') == 'amount'? 'selected="selected"': '' }}>
                                                                Fixed Amount</option>
                                                        </select>
                                                        @error('calculation_method')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror

                                                    </div>
                                                    @if ($income->calculation_method == 'percent')
                                                        <div class="col-lg-4 form-group" id="percentRate">

                                                            <label for="percent_rate">Percent(%)</label>

                                                            <input type="number" name="percent_rate"
                                                                class="form-control custom-form-control"
                                                                aria-describedby="percent_rateHelp"
                                                                placeholder="Enter Percent Rate"
                                                                value="{{ $income->percent_rate }}">
                                                            @error('percent_rate')
                                                                <small
                                                                    class="form-text text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        {{-- <div class="col-md-4">
                                                                    <label for="percent_rate">of Basic
                                                                        Salary</label>
                                                                </div> --}}

                                                </div>
                                            @else
                                                <div class="col-lg-4 form-group" id="amountFixed">

                                                    <label for="fixed_amount">Fixed
                                                        Amount</label>

                                                    <input type="number" name="fixed_amount"
                                                        class="form-control custom-form-control"
                                                        aria-describedby="amountHelp" placeholder="Enter Fixed Amount"
                                                        value="{{ $income->fixed_amount }}">
                                                    @error('fixed_amount')
                                                        <small class="form-text text-danger">{{ $message }}</small>
                                                    @enderror

                                                </div>
                                                @endif
                                                <div class="col-lg-4 form-group">

                                                    <label for="status" class="required">Status</label>

                                                    <select class="form-control custom-form-control" id="status"
                                                        name="status">
                                                        <option value="active"
                                                            {{ old('status', isset($income->status) ? $income->status : '') == 'active' ? 'selected="selected"' : '' }}>
                                                            Active</option>
                                                        <option value="in_active"
                                                            {{ old('status', isset($income->status) ? $income->status : '') == 'in_active' ? 'selected="selected"' : '' }}>
                                                            Inactive</option>
                                                    </select>
                                                    @error('status')
                                                        <small class="form-text text-danger">{{ $message }}</small>
                                                    @enderror

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-create-wrapper mt-1">
                                    <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm btn-create">Update Now</button>
                                </div>
                            </div>
                        </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    </div>

@endsection
@section('js')
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
