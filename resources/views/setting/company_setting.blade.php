@extends('layouts.layout')
@section('title', 'Company Settings')
@section('content')
    <div class="newHrBreadCumb">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <h5>Company Settings</h5>
                </div>
            </div>
        </div>
    </div>
    <form autocomplete="off" method="POST" action="{{ route('company-setting.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body bg-lgrey">
                            <div class="custom-form-wrapper">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="hdetails-wrapper">
                                            <div class="hrprosubHead">
                                                <h5>Basic Settings</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 form-group">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="name" class="required">Company Name</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="hidden" name="id" value="{{ $setting->id }}"
                                                                readonly>
                                                            <input type="text" name="name"
                                                                class="form-control custom-form-control"
                                                                aria-describedby="nameHelp" placeholder="Company Name"
                                                                value="{{ $setting->name }}">
                                                            @error('name')
                                                                <small class="form-text text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 form-group">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="email" class="required">Email</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="email" name="email"
                                                                class="form-control custom-form-control"
                                                                aria-describedby="emailHelp" placeholder="Company Email"
                                                                value="{{ $setting->email }}">
                                                            @error('email')
                                                                <small class="form-text text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 form-group">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="phone" class="required">Phone</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" name="phone"
                                                                class="form-control custom-form-control"
                                                                aria-describedby="phoneHelp" placeholder="Phone"
                                                                value="{{ $setting->phone }}">
                                                            @error('phone')
                                                                <small class="form-text text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 form-group">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="website">Website</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" name="website"
                                                                class="form-control custom-form-control"
                                                                aria-describedby="websiteHelp" placeholder="website"
                                                                value="{{ $setting->website }}">
                                                            @error('website')
                                                                <small class="form-text text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Logo</label>
                                                        </div>
                                                        <div
                                                            class="@if (isset($setting->logo)) col-md-7 @else col-md-10 @endif">
                                                            <input type="file" name="logo" class="form-control">
                                                        </div>
                                                        @if (isset($setting->logo))
                                                            <div class="col-md-3">
                                                                <div class="image-trap">
                                                                    <div class="custom-control custom-checkbox select-1">
                                                                        <input type="checkbox" class="custom-control-input"
                                                                            id="customCheck_logo" name="delete_logo"
                                                                            value="delete_logo">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck_logo"
                                                                            title="Check for delete this image"></label>
                                                                    </div>
                                                                    <img class="img-thumbnail image_list"
                                                                        src="{{ asset('uploads/Setting/thumbnail/' . $setting->logo) }}"
                                                                        alt="No Image">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if (Auth::user()->role == 1)
                                                    <div class="col-md-6 form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label for="main_header_color">Main Color</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="color" name="main_header_color"
                                                                    class="form-control custom-form-control"
                                                                    value="{{ $setting->main_header_color }}">
                                                                @error('main_header_color')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label for="sec_header_color">Secondadry Color</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="color" name="sec_header_color"
                                                                    class="form-control custom-form-control"
                                                                    value="{{ $setting->sec_header_color }}">
                                                                @error('sec_header_color')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="hrprosubHead">
                                                <h5>Other Settings</h5>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="working_hour" class="required">Total Working Hour</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" name="working_hour"
                                                                class="form-control custom-form-control"
                                                                aria-describedby="working_hourHelp"
                                                                placeholder="Total Working Hour"
                                                                value="{{ $setting->working_hour }}">
                                                            @error('working_hour')
                                                                <small
                                                                    class="form-text text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="day_in_month" class="required">Total Working
                                                                Days in month</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" name="day_in_month"
                                                                class="form-control custom-form-control"
                                                                aria-describedby="day_in_monthHelp"
                                                                placeholder="Total Working Days in month"
                                                                value="{{ $setting->day_in_month }}">
                                                            @error('day_in_month')
                                                                <small
                                                                    class="form-text text-danger">{{ $message }}</small>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="name" class="required">Max. allowed time to visit Office (24 hr)</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="max_allow_time" class="form-control custom-form-control time" placeholder="10:00"
                                                                value="{{ $setting->max_allow_time }}">
                                                            @error('max_allow_time')
                                                                <small class="form-text text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- <div class="col-md-12 form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="required">Provide Bonus in Dashain?</label><br>
                                                            <label class="radio-inline"><input type="radio" value="yes" name="bonus"
                                                                    {{ old('bonus', isset($setting->bonus) ? $setting->bonus : '') == 'yes'? 'checked="checked"': '' }}>&nbsp;Yes</label>&nbsp;
                                                            <label class="radio-inline"><input type="radio" value="no"
                                                                    name="bonus"
                                                                    {{ old('bonus', isset($setting->bonus) ? $setting->bonus : '') == 'no'? 'checked="checked"': '' }}>&nbsp;No</label>
                                                        </div>
                                                        <div id="bonusTypeDiv" class="col-md-5" @if ($setting->bonus == 'no') style="display:none;" @endif>
                                                            <label class="required">Bonus Type?</label><br>
                                                            <label class="radio-inline"><input type="radio" value="full" name="bonus_type"
                                                                    {{ old('bonus_type', isset($setting->bonus_type) ? $setting->bonus_type : '') == 'full'? 'checked="checked"': '' }}>&nbsp;Full Basic Salary</label>&nbsp;&nbsp;
                                                            <label class="radio-inline"><input type="radio" value="half"
                                                                    name="bonus_type"
                                                                    {{ old('bonus_type', isset($setting->bonus_type) ? $setting->bonus_type : '') == 'half'? 'checked="checked"': '' }}>&nbsp;Half of Basic Salary</label>&nbsp;&nbsp;
                                                            <label class="radio-inline"><input type="radio" value="customize" name="bonus_type"
                                                                    {{ old('bonus_type', isset($setting->bonus_type) ? $setting->bonus_type : '') == 'customize'? 'checked="checked"': '' }}>&nbsp;Customize Amount</label>&nbsp;

                                                        </div>
                                                        <div id="customizeBonusDiv" class="col-md-3" @if ($setting->bonus_type == 'customize') style="display:block;" @else style="display:none;" @endif>
                                                            <label class="required">Enter Amount</label> <br>
                                                            <input type="text" name="customize_amount"
                                                                class="form-control custom-form-control"
                                                                aria-describedby="customize_amountHelp" placeholder="Amount"
                                                                value="{{ $setting->customize_amount }}">
                                                            @error('customize_amount')
                                                                <small
                                                                    class="form-text text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                <div class="col-12 form-group">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="bank_name">Bank Name</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" name="bank_name"
                                                                class="form-control custom-form-control"
                                                                aria-describedby="bank_nameHelp" placeholder="Bank Name"
                                                                value="{{ $setting->bank_name }}">
                                                            @error('bank_name')
                                                                <small
                                                                    class="form-text text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 form-group">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="bank_branch">Bank Branch</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" branch="bank_branch"
                                                                class="form-control custom-form-control"
                                                                aria-describedby="bank_branchHelp" placeholder="Bank Branch"
                                                                value="{{ $setting->bank_branch }}">
                                                            @error('bank_branch')
                                                                <small
                                                                    class="form-text text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 form-group">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="bank_contact">Bank Contact</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" contact="bank_contact"
                                                                class="form-control custom-form-control"
                                                                aria-describedby="bank_contactHelp"
                                                                placeholder="Bank Contact"
                                                                value="{{ $setting->bank_contact }}">
                                                            @error('bank_contact')
                                                                <small
                                                                    class="form-text text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="min_leave_days_for_review"
                                                                class="required">Minimum Leave days for
                                                                review</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="min_leave_days_for_review"
                                                                class="form-control custom-form-control"
                                                                aria-describedby="min_leave_days_for_reviewHelp"
                                                                placeholder="min_leave_days_for_review"
                                                                value="{{ $setting->min_leave_days_for_review }}">
                                                            @error('min_leave_days_for_review')
                                                                <small
                                                                    class="form-text text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label>Allow Overtime?</label><br>
                                                            <label class="radio-inline"><input type="radio" value="yes"
                                                                    name="overtime"
                                                                    {{ old('overtime', isset($setting->overtime) ? $setting->overtime : '') == 'yes' ? 'checked="checked"' : '' }}>&nbsp;Yes</label>&nbsp;
                                                            <label class="radio-inline"><input type="radio" value="no"
                                                                    name="overtime"
                                                                    {{ old('overtime', isset($setting->overtime) ? $setting->overtime : '') == 'no' ? 'checked="checked"' : '' }}>&nbsp;No</label>
                                                        </div>
                                                        <div id="overtimeDiv" class="col-md-9"
                                                            @if ($setting->overtime == 'no') style="display:none;" @endif>
                                                            <label for="normal_overtime_rate" class="required">Normal
                                                                Holiday Overtime Rate</label>
                                                            <input type="text" name="normal_overtime_rate"
                                                                class="form-control custom-form-control"
                                                                aria-describedby="normal_overtime_rateHelp"
                                                                placeholder="normal_overtime_rate"
                                                                value="{{ $setting->normal_overtime_rate }}">
                                                            @error('normal_overtime_rate')
                                                                <small
                                                                    class="form-text text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="pf">PF Facility?</label><br>
                                                            <label class="radio-inline"><input type="radio" value="yes"
                                                                    name="pf_facility"
                                                                    {{ old('pf_facility', isset($setting->pf_facility) ? $setting->pf_facility : '') == 'yes'? 'checked="checked"': '' }}>&nbsp;Yes</label>&nbsp;
                                                            <label class="radio-inline"><input type="radio" value="no"
                                                                    name="pf_facility"
                                                                    {{ old('pf_facility', isset($setting->pf_facility) ? $setting->pf_facility : '') == 'no'? 'checked="checked"': '' }}>&nbsp;No</label>
                                                        </div>

                                                        <div id="PFValue" class="col-md-12"
                                                            @if ($setting->pf_facility == 'no') style="display:none;" @endif>
                                                            <div class="form-group">
                                                                <label for="gratuity_fac">Employee PF(%)</label>
                                                                <input class="form-control"
                                                                    value="{{ $setting->employee_pf_value * 100 }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="gratuity_fac">Employeer PF(%)</label>
                                                                <input class="form-control"
                                                                    value="{{ $setting->employer_pf_value * 100 }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="gratuity_fac">Gratuity Facility?</label><br>
                                                            <label class="radio-inline"><input type="radio" value="yes"
                                                                    name="gratuity_facility"
                                                                    {{ old('gratuity_facility', isset($setting->gratuity_facility) ? $setting->gratuity_facility : '') == 'yes'? 'checked="checked"': '' }}>&nbsp;Yes</label>&nbsp;
                                                            <label class="radio-inline"><input type="radio" value="no"
                                                                    name="gratuity_facility"
                                                                    {{ old('gratuity_facility', isset($setting->gratuity_facility) ? $setting->gratuity_facility : '') == 'no'? 'checked="checked"': '' }}>&nbsp;No</label>
                                                        </div>
                                                        <div id="grValue" class="col-md-12"
                                                            @if ($setting->gratuity_facility == 'no') style="display:none;" @endif>
                                                            <label for="gratuity_fac">Gratuity(%)</label>
                                                            <input class="form-control"
                                                                value="{{ $setting->gratuity_value * 100 }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @if (Auth::user()->role == 1)
                                                    <div class="col-md-3 form-group">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label for="ssf">SSF Facility?</label><br>
                                                                <label class="radio-inline"><input type="radio"
                                                                        value="yes" name="ssf_facility"
                                                                        {{ old('ssf_facility', isset($setting->ssf_facility) ? $setting->ssf_facility : '') == 'yes'? 'checked="checked"': '' }}>&nbsp;Yes</label>&nbsp;
                                                                <label class="radio-inline"><input type="radio"
                                                                        value="no" name="ssf_facility"
                                                                        {{ old('ssf_facility', isset($setting->ssf_facility) ? $setting->ssf_facility : '') == 'no'? 'checked="checked"': '' }}>&nbsp;No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-3 form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="cit">CIT?</label><br>
                                                            <label class="radio-inline"><input type="radio" value="yes"
                                                                    name="cit_facility"
                                                                    {{ old('cit_facility', isset($setting->cit_facility) ? $setting->cit_facility : '') == 'yes'? 'checked="checked"': '' }}>&nbsp;Yes</label>&nbsp;
                                                            <label class="radio-inline"><input type="radio" value="no"
                                                                    name="cit_facility"
                                                                    {{ old('cit_facility', isset($setting->cit_facility) ? $setting->cit_facility : '') == 'no'? 'checked="checked"': '' }}>&nbsp;No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-create-wrapper">
                                    <div class="d-flex align-items-center justify-content-end">

                                        <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary  btn-create"><i
                                                data-feather="check"></i>Update Now</button>
                                    </div>
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
    <script type="text/javascript" src="{{ asset('js/companysetting.js') }}"></script>
    <script>
        $(window).ready(function() {
            $('.time').chungTimePicker();
        });
    </script>
@endsection
@section('css')
    <style type="text/css">
        .required:after {
            content: " *";
            color: red;
        }

    </style>
@endsection
