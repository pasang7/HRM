@extends('layouts.layout')
@section('title', 'Edit User')

@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Edit Employee</h5>
                    </div>
                </div>
                <div class="col-lg-12 mt-2">
                    <form autocomplete="off" method="POST" action="{{ route('user.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="slug" value="{{ $user->slug }}">
                        <div class="card">
                            <div class="card-body bg-lgrey">
                                <div class="custom-form-wrapper">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="hdetails-wrapper">
                                                <div class="hrprosubHead">
                                                    <h5>Personal Information</h5>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-12">
                                                        <label class="required">Employee Id</label>
                                                        <input type="text" name="employee_id"
                                                            class="form-control custom-form-control"
                                                            value="{{ $user->employee_id }}" readonly>
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label for="name" class="required">Full
                                                            Name</label>
                                                        <input type="text" name="name"
                                                            class="form-control custom-form-control"
                                                            aria-describedby="nameHelp" placeholder="Full Name"
                                                            value="{{ $user->name }}">
                                                        @error('name')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label class="required">Religion</label>
                                                        <select class="form-control custom-form-control" name="religion">
                                                            <option value="">Choose religion</option>
                                                            @foreach ($details['religions'] as $religion)
                                                                <option value="{{ $religion->id }}"
                                                                    {{ old('religion', isset($user->religion) ? $user->religion : '') == $religion->id ? 'selected="selected"' : '' }}>
                                                                    {{ $religion->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('religion')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6 form-group inline">
                                                        <label class="required">Gender</label>
                                                        <br>
                                                        @foreach ($details['genders'] as $gender)
                                                            <label class="radio-inline">
                                                                <input type="radio" value="{{ $gender->value }}"
                                                                    name="gender"
                                                                    {{ old('gender', isset($user->gender) ? $user->gender : '') == $gender->value ? 'checked="checked"' : '' }}>&nbsp;{{ $gender->name }}
                                                            </label> &nbsp;
                                                        @endforeach
                                                        @error('gender')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="col-6 form-group">
                                                        <label for="is_married">Is Married?</label>
                                                        <br>
                                                        <label class="radio-inline"><input type="radio" value="1"
                                                                name="is_married"
                                                                {{ old('is_married', isset($user->is_married) ? $user->is_married : '') == 1 ? 'checked="checked"' : '' }}>&nbsp;Yes</label>&nbsp;
                                                        <label class="radio-inline"><input type="radio" value="0"
                                                                name="is_married"
                                                                {{ old('is_married', isset($user->is_married) ? $user->is_married : '') == 0 ? 'checked="checked"' : '' }}>&nbsp;No</label>
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label for="dob" class="required">Date of
                                                            Birth</label>
                                                        <input type="text" name="dob"
                                                            class="form-control custom-form-control"
                                                            placeholder="Date of birth"
                                                            value="{{ $user->dob->format('m/d/Y') }}">
                                                        @error('dob')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="col-6 form-group">
                                                        <label for="blood_group" class="required">Blood
                                                            Group</label>
                                                        <select class="form-control custom-form-control" name="blood_group">
                                                            <option value="">Blood Group</option>
                                                            @foreach ($details['blood_groups'] as $blood_group)
                                                                <option value="{{ $blood_group->id }}"
                                                                    {{ old('blood_group', isset($user->blood_group) ? $user->blood_group : '') == $blood_group->id? 'selected="selected"': '' }}>
                                                                    {{ $blood_group->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('blood_group')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <p class="hdetail-title"><span>Employee Contact</span></p>
                                                <div class="row">
                                                    <div class="col-6 form-group">
                                                        <label for="phone" class="required">Phone</label>
                                                        <input type="text" name="phone"
                                                            class="form-control custom-form-control"
                                                            aria-describedby="phoneHelp" placeholder="Phone"
                                                            value="{{ $user->phone }}">
                                                        @error('phone')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label for="phone_2">Phone (Alternative)</label>
                                                        <input type="text" name="phone_2"
                                                            class="form-control custom-form-control"
                                                            aria-describedby="phone_2Help" placeholder="Second Phone"
                                                            value="{{ $user->phone_2 }}">
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label for="email" class="required">Email
                                                            (Office)</label>
                                                        <input type="email" class="form-control custom-form-control"
                                                            name="email" aria-describedby="emailHelp" placeholder="Email"
                                                            value="{{ $user->email }}">
                                                        @error('email')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label for="email_2">Email (Personal)</label>
                                                        <input type="text" name="email_2"
                                                            class="form-control custom-form-control"
                                                            aria-describedby="email_2Help" placeholder="Personal Email"
                                                            value="{{ $user->email_2 }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="hrprosubHead">
                                                            <h5>Permanent Address</h5>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="province"
                                                                        class="required">Province</label>
                                                                    <select class="form-control custom-form-control"
                                                                        id="province_select" name="province"
                                                                        onchange="showDistrict(this.value)"
                                                                        url="{{ route('get-district') }}">
                                                                        <option value="">Choose Province
                                                                        </option>
                                                                        @foreach ($details['provinces'] as $province)
                                                                            <option value="{{ $province->id }}"
                                                                                {{ old('province', isset($user->province) ? $user->province : '') == $province->id ? 'selected="selected"' : '' }}>
                                                                                {{ $province->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('province')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group" id="dist">
                                                                    <label for="district"
                                                                        class="required">District</label>
                                                                    <select class="form-control custom-form-control"
                                                                        name="district">
                                                                        <option value="">Choose District
                                                                        </option>
                                                                        @foreach ($details['districts'] as $district)
                                                                            <option value="{{ $district->id }}"
                                                                                {{ old('district', isset($user->district) ? $user->district : '') == $district->id ? 'selected="selected"' : '' }}>
                                                                                {{ $district->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('district')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="municipality_vdc"
                                                                        class="required">Municipality/Vdc</label>
                                                                    <input type="text" name="municipality_vdc"
                                                                        class="form-control custom-form-control"
                                                                        aria-describedby="municipality_vdcHelp"
                                                                        placeholder="Municipality/Vdc"
                                                                        value="{{ $user->municipality_vdc }}">
                                                                    @error('municipality_vdc')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="address"
                                                                        class="required">Address</label>
                                                                    <input type="text" name="address"
                                                                        class="form-control custom-form-control"
                                                                        aria-describedby="addressHelp" placeholder="Address"
                                                                        value="{{ $user->address }}">
                                                                    @error('address')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="hrprosubHead">
                                                            <h5>Temporary Address</h5>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="required">Province</label>
                                                                    <select class="form-control custom-form-control"
                                                                        id="temp_province_select" name="temp_province"
                                                                        onchange="showTempDistrict(this.value)"
                                                                        url="{{ route('get-tempdistrict') }}">
                                                                        <option value="">Choose Province
                                                                        </option>
                                                                        @foreach ($details['provinces'] as $province)
                                                                            <option value="{{ $province->id }}"
                                                                                {{ old('temp_province', isset($user->temp_province) ? $user->temp_province : '') == $province->id? 'selected="selected"': '' }}>
                                                                                {{ $province->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('temp_province')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group" id="temp_dist">
                                                                    <label class="required">District</label>
                                                                    <select class="form-control custom-form-control"
                                                                        name="temp_district">
                                                                        <option value="">Choose District
                                                                        </option>
                                                                        @foreach ($details['districts'] as $district)
                                                                            <option value="{{ $district->id }}"
                                                                                {{ old('temp_district', isset($user->temp_district) ? $user->temp_district : '') == $district->id? 'selected="selected"': '' }}>
                                                                                {{ $district->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('temp_district')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required">Municipality/Vdc</label>
                                                                    <input type="text" name="temp_municipality_vdc"
                                                                        class="form-control custom-form-control"
                                                                        placeholder="Municipality/Vdc"
                                                                        value="{{ $user->temp_municipality_vdc }}">
                                                                    @error('temp_municipality_vdc')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required">Address</label>
                                                                    <input type="text" name="temp_address"
                                                                        class="form-control custom-form-control"
                                                                        aria-describedby="temp_addressHelp"
                                                                        placeholder="Address"
                                                                        value="{{ $user->temp_address }}">
                                                                    @error('temp_address')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hrprosubHead">
                                                    <h5>Employee Contracts</h5>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6 form-group">
                                                        <label class="required">Department</label>
                                                        <select class="form-control custom-form-control"
                                                            name="department_id">
                                                            <option value="">Choose Department</option>
                                                            @foreach ($details['departments'] as $department)
                                                                <option value="{{ $department->id }}"
                                                                    {{ old('department_id', isset($user->department_id) ? $user->department_id : '') == $department->id? 'selected="selected"': '' }}>
                                                                    {{ $department->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('department_id')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label for="designation" class="required">Designation</label>
                                                        <select class="form-control custom-form-control"
                                                            name="designation">
                                                            <option value="">Choose Designation</option>
                                                            @foreach ($details['designations'] as $designation)
                                                                <option value="{{ $designation->id }}"
                                                                    {{ old('designation', isset($user->designation) ? $user->designation : '') == $designation->id? 'selected="selected"': '' }}>
                                                                    {{ $designation->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('designation')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label for="role" class="required">Role</label>
                                                        <select class="form-control custom-form-control" name="role">
                                                            <option value="">Role</option>
                                                            @foreach ($details['roles'] as $role)
                                                                <option value="{{ $role->id }}"
                                                                    {{ old('role', isset($user->role) ? $user->role : '') == $role->id ? 'selected="selected"' : '' }}>
                                                                    {{ $role->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('role')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label class="required">Is Head
                                                            (Supervisor)?</label>
                                                        <select class="form-control custom-form-control" name="is_head">
                                                            <option value="no"
                                                                {{ old('is_head', isset($user->is_head) ? $user->is_head : '') == 'no' ? 'selected="selected"' : '' }}>
                                                                No</option>
                                                            <option value="yes"
                                                                {{ old('is_head', isset($user->is_head) ? $user->is_head : '') == 'yes' ? 'selected="selected"' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                        @error('is_head')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label for="interview_date" class="required">Interview
                                                            Date</label>
                                                        <input type="text" name="interview_date"
                                                            class="form-control custom-form-control"
                                                            placeholder="Interview Date"
                                                            value="{{ $user->interview_date->format('m/d/Y') }}">
                                                        @error('interview_date')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label for="joined" class="required">Joined
                                                            Date</label>
                                                        <input type="text" name="joined"
                                                            class="form-control custom-form-control"
                                                            placeholder="Joined Date"
                                                            value="{{ $user->joined->format('m/d/Y') }}">
                                                        @error('joined')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label for="contract_type" class="required">Contract
                                                            Type</label>
                                                        <select class="form-control custom-form-control"
                                                            name="contract_type">
                                                            <option value="">Contract Type</option>
                                                            @foreach ($details['contract_types'] as $contract_type)
                                                                <option value="{{ $contract_type->id }}"
                                                                    {{ old('contract_type', isset($user->contract_type) ? $user->contract_type : '') == $contract_type->id? 'selected="selected"': '' }}>
                                                                    {{ $contract_type->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('contract_type')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <label for="salary" class="required">Basic
                                                            Salary</label>
                                                        <input type="number" name="salary"
                                                            class="form-control custom-form-control employee_salary"
                                                            aria-describedby="salaryHelp" placeholder="0.00"
                                                            value="{{ $user->current_salary->salary }}">
                                                        @error('salary')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="hrprosubHead">
                                                    <h5>Additional Details</h5>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div
                                                            class="form-group  @if (isset($user->profile_image)) col-md-9 @else col-md-12 @endif">
                                                            <label>Photo [jpg, jpeg, png]</label>
                                                            <input type="file" name="profile_image" class="form-control">
                                                        </div>
                                                        @error('profile_image')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror

                                                        @if (isset($user->profile_image))
                                                            <div class="col-md-3">
                                                                <div class="custom-control custom-checkbox select-1">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="customCheck_profile_image"
                                                                        name="delete_profile_image"
                                                                        value="delete_profile_image">
                                                                    <label class="custom-control-label"
                                                                        for="customCheck_profile_image"
                                                                        title="Check for delete this image"></label>
                                                                </div>
                                                                <img class="img-thumbnail image_list img-fluid"
                                                                    src="{{ asset('uploads/UserDocuments/thumbnail/' . $user->profile_image) }}"
                                                                    alt="No Image" width="100">
                                                            </div>
                                                        @endif
                                                        <!-- citizenship -->
                                                        <div
                                                            class="form-group @if (isset($user->citizenship)) col-md-9 @else col-md-12 @endif">
                                                            <label>Citizenship [pdf]</label>
                                                            <input type="file" class="form-control" name="citizenship">
                                                        </div>
                                                        @error('citizenship')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                        @if (isset($user->citizenship))
                                                            <div class="col-md-3">
                                                                <div class="custom-control custom-checkbox select-1">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="customCheck_citizenship"
                                                                        name="delete_citizenship"
                                                                        value="delete_citizenship">
                                                                    <label class="custom-control-label"
                                                                        for="customCheck_citizenship"
                                                                        title="Check for delete"></label>
                                                                </div>
                                                                <a href="{{ asset('uploads/UserDocuments/' . $user->citizenship) }}"
                                                                    target="_blank">
                                                                    <img class="img-thumbnail image_list img-fluid"
                                                                        src="{{ asset('theme/images/pdf.png') }}"
                                                                        alt="No Image" width="100">
                                                                </a>
                                                            </div>
                                                        @endif
                                                        <!-- CV -->
                                                        <div
                                                            class="form-group @if (isset($user->cv)) col-md-9 @else col-md-12 @endif">
                                                            <label>CV / Resume [pdf]</label>
                                                            <input type="file" class="form-control" name="cv">
                                                        </div>
                                                        @error('cv')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                        @if (isset($user->cv))
                                                            <div class="col-md-3">
                                                                <div class="custom-control custom-checkbox select-1">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="customCheck_cv" name="delete_cv"
                                                                        value="delete_cv">
                                                                    <label class="custom-control-label"
                                                                        for="customCheck_cv"
                                                                        title="Check for delete"></label>
                                                                </div>
                                                                <a href="{{ asset('uploads/UserDocuments/' . $user->cv) }}"
                                                                    target="_blank">
                                                                    <img class="img-thumbnail image_list img-fluid"
                                                                        src="{{ asset('theme/images/pdf.png') }}"
                                                                        alt="No Image" width="100">
                                                                </a>
                                                            </div>
                                                        @endif
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label class="required">Allow
                                                                    Overtime</label>
                                                                <select name="allow_overtime"
                                                                    class="form-control custom-form-control">
                                                                    <option value="yes"
                                                                        {{ old('allow_overtime', isset($user->allow_overtime) ? $user->allow_overtime : '') == 'yes'? 'selected="selected"': '' }}>
                                                                        Yes</option>
                                                                    <option value="no"
                                                                        {{ old('allow_overtime', isset($user->allow_overtime) ? $user->allow_overtime : '') == 'no'? 'selected="selected"': '' }}>
                                                                        No</option>
                                                                </select>
                                                                @error('allow_overtime')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label class="required">Tax
                                                                    Calculate</label>
                                                                <select name="tax_calculate"
                                                                    class="form-control custom-form-control">
                                                                    <option value="yes"
                                                                        {{ old('tax_calculate', isset($user->tax_calculate) ? $user->tax_calculate : '') == 'yes'? 'selected="selected"': '' }}>
                                                                        Yes</option>
                                                                    <option value="no"
                                                                        {{ old('tax_calculate', isset($user->tax_calculate) ? $user->tax_calculate : '') == 'no'? 'selected="selected"': '' }}>
                                                                        No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label class="required">Tax in
                                                                    Payslip</label>
                                                                <select name="salary_slip"
                                                                    class="form-control custom-form-control">
                                                                    <option value="show"
                                                                        {{ old('salary_slip', isset($user->salary_slip) ? $user->salary_slip : '') == 'show'? 'selected="selected"': '' }}>
                                                                        Show</option>
                                                                    <option value="hide"
                                                                        {{ old('salary_slip', isset($user->salary_slip) ? $user->salary_slip : '') == 'hide'? 'selected="selected"': '' }}>
                                                                        Hide</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @if ($setting->ssf_facility == 'yes')
                                                            <div class="col-md-4 mt-20">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="yes" id="pan" name="has_pan"
                                                                        {{ old('has_pan', isset($user->has_pan) ? $user->has_pan : '') == 'yes' ? 'checked="checked"' : '' }}>
                                                                    <label class="form-check-label" for="pan">
                                                                        Add Pan Number
                                                                    </label>
                                                                </div>
                                                                <div class="form-group mt-20" id="panDiv"
                                                                    @if ($user->has_pan == 'no') style="display: none;" @endif>
                                                                    <label for="pan_no" class="required">Enter
                                                                        PAN</label>
                                                                    <input type="number" name="pan_no"
                                                                        class="form-control custom-form-control"
                                                                        aria-describedby="pan_noHelp"
                                                                        placeholder="Enter PAN Number"
                                                                        value="{{ $user->pan_no }}">
                                                                    @error('pan_no')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($setting->ssf_facility == 'yes')
                                                            <div class="col-md-4 mt-20">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="yes" id="ssf" name="has_ssf"
                                                                        {{ old('has_ssf', isset($user->has_ssf) ? $user->has_ssf : '') == 'yes' ? 'checked="checked"' : '' }}>
                                                                    <label class="form-check-label" for="ssf">
                                                                        Add SSF Number
                                                                    </label>
                                                                </div>
                                                                <div class="form-group mt-20" id="ssfDiv"
                                                                    @if ($user->has_ssf == 'no') style="display: none;" @endif>
                                                                    <label for="ssf_no" class="required">Enter
                                                                        SSF</label>
                                                                    <input type="number" name="ssf_no"
                                                                        class="form-control custom-form-control"
                                                                        aria-describedby="ssf_noHelp"
                                                                        placeholder="Enter SSF Number"
                                                                        value="{{ $user->ssf_no }}">
                                                                    @error('ssf_no')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($setting->pf_facility == 'yes')
                                                            <div class="col-md-4 mt-20">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="yes" id="pf" name="has_pf"
                                                                        {{ old('has_pf', isset($user->has_pf) ? $user->has_pf : '') == 'yes' ? 'checked="checked"' : '' }}>
                                                                    <label class="form-check-label" for="pf">
                                                                        Add PF Number
                                                                    </label>
                                                                </div>
                                                                <div class="form-group mt-20" id="pfDiv"
                                                                    @if ($user->has_pf == 'no') style="display: none;" @endif>
                                                                    <label for="pf_no" class="required">Enter
                                                                        PF</label>
                                                                    <input type="number" name="pf_no"
                                                                        class="form-control custom-form-control"
                                                                        aria-describedby="pf_noHelp"
                                                                        placeholder="Enter PF Number"
                                                                        value="{{ $user->pf_no }}">
                                                                    @error('pf_no')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($setting->cit_facility == 'yes')
                                                            <div class="col-md-12 mt-20">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="yes" name="has_cit" id="cit"
                                                                        {{ old('has_cit', isset($user->has_cit) ? $user->has_cit : '') == 'yes' ? 'checked="checked"' : '' }}>
                                                                    <label class="form-check-label" for="cit">
                                                                        Add CIT Details
                                                                    </label>
                                                                </div>
                                                                <div class="row" id="citDiv"
                                                                    @if ($user->has_cit == 'no') style="display: none;" @endif>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mt-20">
                                                                            <label for="cit_no"
                                                                                class="required">Enter
                                                                                CIT No</label>
                                                                            <input type="number" name="cit_no"
                                                                                class="form-control custom-form-control"
                                                                                aria-describedby="cit_noHelp"
                                                                                placeholder="Enter CIT Number"
                                                                                value="{{ $user->cit_no }}">
                                                                            @error('cit_no')
                                                                                <small
                                                                                    class="form-text text-danger">{{ $message }}</small>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mt-20">
                                                                            <label for="cit_percent"
                                                                                class="required">Enter
                                                                                CIT
                                                                                Percentage</label>
                                                                            <input type="text" name="cit_percent"
                                                                                class="form-control custom-form-control cit_percentage"
                                                                                aria-describedby="cit_percentHelp"
                                                                                placeholder="Enter CIT Percentage"
                                                                                value="{{ $user->cit_percent }}">
                                                                            @error('cit_percent')
                                                                                <small
                                                                                    class="form-text text-danger">{{ $message }}</small>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mt-20">
                                                                            <label for="cit_amount"
                                                                                class="required">Enter
                                                                                CIT
                                                                                Amount</label>
                                                                            <input type="text" name="cit_amount"
                                                                                class="form-control custom-form-control cit_amount"
                                                                                aria-describedby="cit_amountHelp"
                                                                                placeholder="Enter CIT Amount"
                                                                                value="{{ $user->cit_amount }}">
                                                                            @error('cit_amount')
                                                                                <small
                                                                                    class="form-text text-danger">{{ $message }}</small>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="hdetails-wrapper">
                                                <div class="hrprosubHead">
                                                    <h5>Leave Informations</h5>
                                                </div>

                                                <div class="row">
                                                    @foreach ($leaves as $key => $leave)
                                                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="form-group row">
                                                                <label for="input"
                                                                    class="col-sm-4 col-form-label">{{ $leave['name'] }}</label>
                                                                <div class="col-sm-8">
                                                                    <input class="form-control  custom-form-control"
                                                                        name="leave[{{ $key }}]"
                                                                        value="{{ $leave['days'] }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="hrprosubHead">
                                                            <h5>Leave Review &
                                                                Approval</h5>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 form-group">
                                                                <label class="required">Review &
                                                                    Approval</label>
                                                                <select name="first_approval_id"
                                                                    class="form-control custom-form-control">
                                                                    <option value="">Select</option>
                                                                    @foreach ($details['top_level_users'] as $topuser)
                                                                        <option value="{{ $topuser->id }}"
                                                                            {{ old('first_approval_id', isset($user->first_approval_id) ? $user->first_approval_id : '') == $topuser->id? 'selected="selected"': '' }}>
                                                                            {{ $topuser->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('first_approval_id')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <label>CEO Approval</label>
                                                                <select name="sec_approval_id"
                                                                    class="form-control custom-form-control">
                                                                    <option value="">Select</option>
                                                                    @foreach ($details['top_level_users'] as $topuser)
                                                                        @if ($topuser->is_head == 'yes' && $topuser->role == 2)
                                                                            <option value="{{ $topuser->id }}"
                                                                                {{ old('sec_approval_id', isset($user->sec_approval_id) ? $user->sec_approval_id : '') == $topuser->id? 'selected="selected"': '' }}>
                                                                                {{ $topuser->name }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-create-wrapper">
                                        <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm btn-create">Update</button>
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

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $('input[name="dob"]').daterangepicker({
            "singleDatePicker": true,
            "maxDate": moment().subtract(15, 'years')
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
        $('input[name="joined"]').daterangepicker({
            "singleDatePicker": true,
            "maxDate": moment()
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
        $('input[name="interview_date"]').daterangepicker({
            "singleDatePicker": true,
            "maxDate": moment()
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
    </script>
    <script type="text/javascript" src="{{ asset('js/district.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/empotherdetails.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/cit.js') }}"></script>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style type="text/css">
        .required:after {
            content: " *";
            color: red;
        }

    </style>
@endsection
