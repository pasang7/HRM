@extends('layouts.layout')
@section('title', 'Income')
@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Create Allowance</h5>
                    </div>
                </div>
                <div class="col-lg-5 mt-2">
                    <div class="newHrFormGrp  bg-lgrey">
                        <form autocomplete="off" method="POST" action="{{ route('payroll-setting.income.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="hdetails-wrapper">
                                        <div class="row">
                                            <div class="col-12 form-group">

                                                <label for="name" class="required">Title</label>

                                                <input type="text" name="name" class="form-control custom-form-control"
                                                    aria-describedby="nameHelp" placeholder="Enter Allowance Title"
                                                    value="{{ old('name') }}">
                                                @error('name')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror

                                            </div>
                                            <div class="col-12 form-group">

                                                <label for="short_name">Short Name</label>

                                                <input type="text" name="short_name"
                                                    class="form-control custom-form-control"
                                                    aria-describedby="short_nameHelp" placeholder="Enter Short Name"
                                                    value="{{ old('short_name') }}">
                                                @error('short_name')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror

                                            </div>
                                            <div class="col-12 form-group">

                                                <label for="remarks">Remarks</label>

                                                <textarea class="form-control custom-form-control" name="remarks">
                                                                {{ old('remarks') }}
                                                            </textarea>

                                            </div>
                                            <div class="col-12 form-group">

                                                <label for="calculation_method" class="required">Calculation
                                                    Method</label>

                                                <select class="form-control custom-form-control" id="calculation_method"
                                                    name="calculation_method" onchange="percentRate(this.value)">
                                                    <option value="">Calculation Method
                                                    </option>
                                                    <option value="percent">Percent-wise
                                                    </option>
                                                    <option value="amount">Fixed Amount
                                                    </option>
                                                </select>
                                                @error('calculation_method')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror

                                            </div>
                                            <div class="col-12 form-group" style="display: none;" id="percentRate">

                                                <label for="percent_rate">Percent(%)</label>

                                                <input type="number" name="percent_rate"
                                                    class="form-control custom-form-control"
                                                    aria-describedby="percent_rateHelp" placeholder="Enter Percent Rate">
                                                @error('percent_rate')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            {{-- <div class="col-md-4">
                                                <label for="percent_rate">of Basic
                                                    Salary</label>

                                            </div> --}}
                                            <div class="col-12 form-group" id="amountFixed" style="display: none;">

                                                <label for="fixed_amount">Fixed
                                                    Amount</label>

                                                <input type="number" name="fixed_amount"
                                                    class="form-control custom-form-control" aria-describedby="amountHelp"
                                                    placeholder="Enter Fixed Amount">
                                                @error('fixed_amount')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror

                                            </div>
                                            <div class="col-12 form-group">

                                                <label for="status" class="required">Status</label>

                                                <select class="form-control custom-form-control" id="status" name="status">
                                                    <option value="active">Active</option>
                                                    <option value="in_active">Inactive
                                                    </option>
                                                </select>
                                                @error('status')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-create-wrapper">
                                <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm btn-create">Create</button>
                            </div>
                        </form>
                    </div>
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
