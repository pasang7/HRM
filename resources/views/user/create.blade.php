@extends('layouts.layout')
@section('title', 'Create User')
@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Create Employee</h5>
                    </div>
                </div>
                <div class="col-lg-12">
                    <form autocomplete="off" method="POST" action="{{ route('user.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
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
                                                                    value="{{ $details['employeeId'] + 1 }}" readonly>
                                                            </div>
                                                            <div class="col-6 form-group">
                                                                <label for="name" class="required">Full
                                                                    Name</label>
                                                                <input type="text" name="name"
                                                                    class="form-control custom-form-control"
                                                                    aria-describedby="nameHelp" placeholder="Full Name"
                                                                    value="{{ old('name') }}">
                                                                @error('name')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col-6 form-group">
                                                                <label class="required">Religion</label>
                                                                <select class="form-control custom-form-control"
                                                                    name="religion">
                                                                    <option value="">Choose religion</option>
                                                                    @foreach ($details['religions'] as $religion)
                                                                        <option value="{{ $religion->id }}">
                                                                            {{ $religion->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('religion')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col-6 form-group inline">
                                                                <label class="required">Gender</label>
                                                                <br>
                                                                @foreach ($details['genders'] as $gender)
                                                                    <label class="radio-inline">
                                                                        <input type="radio" value="{{ $gender->value }}"
                                                                            name="gender">&nbsp;{{ $gender->name }}
                                                                    </label> &nbsp;
                                                                @endforeach
                                                                @error('gender')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-6 form-group">
                                                                <label for="is_married">Is Married?</label>
                                                                <br>
                                                                <label class="radio-inline"><input type="radio" value="1"
                                                                        name="is_married">&nbsp;Yes</label>&nbsp;
                                                                <label class="radio-inline"><input type="radio" value="0"
                                                                        name="is_married" checked>&nbsp;No</label>
                                                            </div>
                                                            <div class="col-6 form-group">
                                                                <label for="dob" class="required">Date of
                                                                    Birth</label>
                                                                <input type="text" name="dob" id="dob"
                                                                    class="form-control custom-form-control"
                                                                    placeholder="Date of birth"
                                                                    value="{{ old('dob') }}">
                                                                @error('dob')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-6 form-group">
                                                                <label for="blood_group" class="required">Blood
                                                                    Group</label>
                                                                <select class="form-control custom-form-control"
                                                                    name="blood_group">
                                                                    <option value="">Blood Group</option>
                                                                    @foreach ($details['blood_groups'] as $blood_group)
                                                                        <option value="{{ $blood_group->id }}">
                                                                            {{ $blood_group->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('blood_group')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="hrprosubHead">
                                                            <h5>Employee Contact</h5>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-6 form-group">
                                                                <label for="phone" class="required">Phone</label>
                                                                <input type="text" name="phone"
                                                                    class="form-control custom-form-control"
                                                                    aria-describedby="phoneHelp" placeholder="Phone"
                                                                    value="{{ old('phone') }}">
                                                                @error('phone')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col-6 form-group">
                                                                <label for="phone_2">Phone (Alternative)</label>
                                                                <input type="text" name="phone_2"
                                                                    class="form-control custom-form-control"
                                                                    aria-describedby="phone_2Help"
                                                                    placeholder="Second Phone"
                                                                    value="{{ old('phone_2') }}">
                                                            </div>
                                                            <div class="col-6 form-group">
                                                                <label for="email" class="required">Email
                                                                    (Office)</label>
                                                                <input type="email" class="form-control custom-form-control"
                                                                    name="email" aria-describedby="emailHelp"
                                                                    placeholder="Email" value="{{ old('email') }}">
                                                                @error('email')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col-6 form-group">
                                                                <label for="email_2">Email (Personal)</label>
                                                                <input type="text" name="email_2"
                                                                    class="form-control custom-form-control"
                                                                    aria-describedby="email_2Help"
                                                                    placeholder="Personal Email"
                                                                    value="{{ old('email_2') }}">
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
                                                                                    <option value="{{ $province->id }}">
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
                                                                                    <option value="{{ $district->id }}">
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
                                                                                value="{{ old('municipality_vdc') }}">
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
                                                                                aria-describedby="addressHelp"
                                                                                placeholder="Address"
                                                                                value="{{ old('address') }}">
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
                                                                                id="temp_province_select"
                                                                                name="temp_province"
                                                                                onchange="showTempDistrict(this.value)"
                                                                                url="{{ route('get-tempdistrict') }}">
                                                                                <option value="">Choose Province
                                                                                </option>
                                                                                @foreach ($details['provinces'] as $province)
                                                                                    <option value="{{ $province->id }}">
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
                                                                                    <option value="{{ $district->id }}">
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
                                                                            <label
                                                                                class="required">Municipality/Vdc</label>
                                                                            <input type="text" name="temp_municipality_vdc"
                                                                                class="form-control custom-form-control"
                                                                                placeholder="Municipality/Vdc"
                                                                                value="{{ old('temp_municipality_vdc') }}">
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
                                                                                value="{{ old('temp_address') }}">
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
                                                                        <option value="{{ $department->id }}">
                                                                            {{ $department->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('department_id')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col-6 form-group">
                                                                <label for="designation"
                                                                    class="required">Designation</label>
                                                                <select class="form-control custom-form-control"
                                                                    name="designation">
                                                                    <option value="">Choose Designation</option>
                                                                    @foreach ($details['designations'] as $designation)
                                                                        <option value="{{ $designation->id }}">
                                                                            {{ $designation->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('designation')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col-6 form-group">
                                                                <label for="role" class="required">Role</label>
                                                                <select class="form-control custom-form-control"
                                                                    name="role">
                                                                    <option value="">Role</option>
                                                                    @foreach ($details['roles'] as $role)
                                                                        <option value="{{ $role->id }}">
                                                                            {{ $role->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('role')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col-6 form-group">
                                                                <label class="required">Is Head
                                                                    (Supervisor)?</label>
                                                                <select class="form-control custom-form-control"
                                                                    name="is_head">
                                                                    <option value="no">No</option>
                                                                    <option value="yes">Yes</option>
                                                                </select>
                                                                @error('is_head')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col-6 form-group">
                                                                <label for="interview_date"
                                                                    class="required">Interview
                                                                    Date</label>
                                                                <input type="text" name="interview_date"
                                                                    class="form-control custom-form-control datepick"
                                                                    placeholder="Interview Date"
                                                                    value="{{ old('interview_date') }}">
                                                                @error('interview_date')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col-6 form-group">
                                                                <label for="joined" class="required">Joined
                                                                    Date</label>
                                                                <input type="text" name="joined"
                                                                    class="form-control custom-form-control datepick"
                                                                    placeholder="Joined Date"
                                                                    value="{{ old('joined') }}">
                                                                @error('joined')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col-6 form-group">
                                                                <label for="contract_type" class="required">Contract
                                                                    Type</label>
                                                                <select class="form-control custom-form-control"
                                                                    name="contract_type" id="contract_type" onchange="showContractWiseDate(this.value)">
                                                                    <option value="">Contract Type</option>
                                                                    @foreach ($details['contract_types'] as $contract_type)
                                                                        <option value="{{ $contract_type->slug }}">
                                                                            {{ $contract_type->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('contract_type')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                                <br>
                                                                <div class="startDiv form-group" style="display:none;">
                                                                    <label for="start_date">Contract Start Date</label>
                                                                    <input type="text" name="start" id="contract_start" class="form-control custom-form-control"
                                                                        placeholder="Start From" value="{{ old('start_date') }}" >
                                                                    @error('start_date')
                                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="endDiv form-group" style="display:none;">
                                                                    <label for="end_date">Contract End Date</label>
                                                                    <input type="text" name="end" id="contract_end" class="form-control custom-form-control"
                                                                        placeholder="Start From" value="{{ old('end_date') }}" >
                                                                    @error('end_date')
                                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-6 form-group">
                                                                <label for="salary" class="required">Basic
                                                                    Salary</label>
                                                                <input type="number" name="salary"
                                                                    class="form-control custom-form-control employee_salary"
                                                                    aria-describedby="salaryHelp" placeholder="0.00"
                                                                    value="{{ old('salary') }}">
                                                                @error('salary')
                                                                    <small
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="col-12 form-group">
                                                                <label class="required">Permission on this
                                                                    system</label>
                                                                <br>
                                                                <input type="checkbox" onclick="toggle(this);" id="checkall"
                                                                    value="0" name="permission[]"> All<br>
                                                                <input type="checkbox" onclick="toggleX(this);" value="1"
                                                                    name="permission[]" checked>
                                                                Send Report<br>
                                                                <input type="checkbox" onclick="toggleX(this);" value="2"
                                                                    name="permission[]">
                                                                View Report<br>
                                                                <input type="checkbox" onclick="toggleX(this);" value="3"
                                                                    name="permission[]" checked>
                                                                Do Attendance<br>
                                                            </div>
                                                        </div>
                                                        <div class="hrprosubHead">
                                                            <h5>Additional Details</h5>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label>Photo [jpg, jpeg, png]</label>
                                                                        <input type="file" name="profile_image"
                                                                            class="form-control">

                                                                    </div>
                                                                    @error('profile_image')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label>Citizenship [pdf]</label>
                                                                        <input type="file" class="form-control"
                                                                            name="citizenship">
                                                                    </div>
                                                                    @error('citizenship')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label>CV / Resume [pdf]</label>
                                                                        <input type="file" class="form-control"
                                                                            name="cv">
                                                                    </div>
                                                                    @error('cv')
                                                                        <small
                                                                            class="form-text text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label class="required">Allow
                                                                            Overtime</label>
                                                                        <select name="allow_overtime"
                                                                            class="form-control custom-form-control">
                                                                            <option value="yes">Yes</option>
                                                                            <option value="no">No</option>
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
                                                                            <option value="yes">Yes</option>
                                                                            <option value="no">No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label class="required">Tax in
                                                                            Payslip</label>
                                                                        <select name="salary_slip"
                                                                            class="form-control custom-form-control">
                                                                            <option value="show">Show</option>
                                                                            <option value="hide">Hide</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 mt-20">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="yes" id="pan" name="has_pan">
                                                                        <label class="form-check-label" for="pan">
                                                                            Add Pan Number
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group mt-20" id="panDiv"
                                                                        style="display: none;">
                                                                        <label for="pan_no" class="required">Enter
                                                                            PAN</label>
                                                                        <input type="number" name="pan_no"
                                                                            class="form-control custom-form-control"
                                                                            aria-describedby="pan_noHelp"
                                                                            placeholder="Enter PAN Number"
                                                                            value="{{ old('pan_no') }}">
                                                                        @error('pan_no')
                                                                            <small
                                                                                class="form-text text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                @if ($setting->ssf_facility == 'yes')
                                                                    <div class="col-md-4 mt-20">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                value="yes" id="ssf" name="has_ssf">
                                                                            <label class="form-check-label" for="ssf">
                                                                                Add SSF Number
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-group mt-20" id="ssfDiv"
                                                                            style="display: none;">
                                                                            <label for="ssf_no"
                                                                                class="required">Enter
                                                                                SSF</label>
                                                                            <input type="number" name="ssf_no"
                                                                                class="form-control custom-form-control"
                                                                                aria-describedby="ssf_noHelp"
                                                                                placeholder="Enter SSF Number"
                                                                                value="{{ old('ssf_no') }}">
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
                                                                                value="yes" id="pf" name="has_pf">
                                                                            <label class="form-check-label" for="pf">
                                                                                Add PF Number
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-group mt-20" id="pfDiv"
                                                                            style="display: none;">
                                                                            <label for="pf_no" class="required">Enter
                                                                                PF</label>
                                                                            <input type="number" name="pf_no"
                                                                                class="form-control custom-form-control"
                                                                                aria-describedby="pf_noHelp"
                                                                                placeholder="Enter PF Number"
                                                                                value="{{ old('pf_no') }}">
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
                                                                            style="display: none;">
                                                                            <div class="col-md-4">
                                                                                <div class="form-group mt-20">
                                                                                    <label for="cit_no"
                                                                                        class="required">Enter
                                                                                        CIT No</label>
                                                                                    <input type="text" name="cit_no"
                                                                                        class="form-control custom-form-control"
                                                                                        aria-describedby="cit_noHelp"
                                                                                        placeholder="Enter CIT Number"
                                                                                        value="{{ old('cit_no') }}">
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
                                                                                    <input type="number" name="cit_percent"
                                                                                        class="form-control custom-form-control cit_percentage"
                                                                                        aria-describedby="cit_percentHelp"
                                                                                        placeholder="Enter CIT Amount"
                                                                                        value="{{ old('cit_percent') }}">
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
                                                                                        CIT Amount</label>
                                                                                    <input type="text" name="cit_amount"
                                                                                        class="form-control custom-form-control cit_amount"
                                                                                        aria-describedby="cit_amountHelp"
                                                                                        placeholder="Enter CIT Amount"
                                                                                        value="{{ old('cit_amount') }}">
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
                                                            @foreach ($details['leave_types'] as $type)
                                                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                                    <div class="form-group row">
                                                                        <label for="input"
                                                                            class="col-sm-4 col-form-label">{{ $type->name }}</label>
                                                                        <div class="col-sm-8">
                                                                            <input class="form-control  custom-form-control"
                                                                                name="leave[{{ $type->id }}]"
                                                                                value="{{ $type->days }}" id="input">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="hrprosubHead">
                                                                    <h5>Leave Review & Approval</h5>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6 form-group">
                                                                        <label class="required">Review &
                                                                            Approval</label>
                                                                        <select name="first_approval_id"
                                                                            class="form-control custom-form-control">
                                                                            <option value="">Select</option>
                                                                            @foreach ($details['top_level_users'] as $user)
                                                                                <option value="{{ $user->id }}">
                                                                                    {{ $user->name }}</option>
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
                                                                            @foreach ($details['top_level_users'] as $user)
                                                                                @if ($user->is_head == 'yes' && $user->role == 2)
                                                                                    <option value="{{ $user->id }}">
                                                                                        {{ $user->name }}</option>
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
                                                <button type="submit"
                                                    style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm btn-create">Create</button>
                                            </div>
                                        </div>
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
    <script type="text/javascript" src="{{ asset('js/daterangepicker.min.js') }}"></script>
    <script>
        function toggleX(x) {
            checkbox = document.getElementById('checkall');
            checkbox.checked = false;
        }

        function toggle(source) {
            checkboxes = document.getElementsByName('permission[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
    <script type="text/javascript" src="{{ asset('js/district.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/empotherdetails.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/cit.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/contract.js') }}"></script>
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
