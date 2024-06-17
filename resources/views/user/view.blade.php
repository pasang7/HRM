@extends('layouts.layout')
@section('title', 'Staff Details')
@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Staff Details</h5>
                            {{-- <a href="" title=" Create Project" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm"><i data-feather="plus"></i>Add
                                Department</a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
                    <div class="custom-wrapper">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="pills-employee-profile-tab" data-toggle="pill"
                                            href="#pills-employee-profile" role="tab" aria-controls="pills-employee-profile"
                                            aria-selected="true">Staff Overview</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-documents-tab" data-toggle="pill"
                                            href="#pills-documents" role="tab" aria-controls="pills-documents"
                                            aria-selected="false">User Documents</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-leave-detail-tab" data-toggle="pill"
                                            href="#pills-leave-detail" role="tab" aria-controls="pills-leave-detail"
                                            aria-selected="false">Leave Report</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-employee-profile" role="tabpanel"
                                        aria-labelledby="pills-employee-profile-tab">
                                        <div class="row">

                                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                <div class="card bshadow">
                                                    <div style="margin-bottom: 30px;text-align: center;">
                                                        <?php
                                                        $profile_image = $details['user']->profile_image ? $details['user']->profile_image : '1.png';
                                                        ?>
                                                        <img src="{{ asset('uploads/UserDocuments/thumbnail/' . $profile_image) }}"
                                                            class="img-fluid" style="width:30%;">
                                                    </div>
                                                    <div class="card-header bg-white">
                                                        <p class="fw-600 mb-0">Personal Details</p>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Name:</span>
                                                                <div class="ml-auto">{{ $details['user']->name }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Gender:</span>
                                                                <div class="ml-auto">
                                                                    {{ $details['user']->gender == '0' ? 'Female' : 'Male' }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">DOB:</span>
                                                                <div class="ml-auto">
                                                                    {{ date('d M, Y', strtotime($details['user']->dob)) }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Marital Status:</span>
                                                                <div class="ml-auto">
                                                                    {{ $details['user']->is_married == '0' ? 'Unmarried' : 'Married' }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Religion:</span>
                                                                <div class="ml-auto">
                                                                    {{ $details['user']->userReligion->name }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Blood Group:</span>
                                                                <div class="ml-auto">
                                                                    {{ $details['user']->bloodGroup->name }}
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                                <div class="card bshadow">
                                                    <div class="card-header bg-white">
                                                        <p class="fw-600 mb-0">Contact Details</p>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group list-group-flush">
                                                            @if ($details['user']->email_2)
                                                                <li class="list-group-item staff_details">
                                                                    <span class="font-weight-semibold">Email
                                                                        (personal):</span>
                                                                    <div class="ml-auto">
                                                                        {{ $details['user']->email_2 }}</div>
                                                                </li>
                                                            @endif
                                                            @if ($details['user']->phone_2)
                                                                <li class="list-group-item staff_details">
                                                                    <span class="font-weight-semibold">Phone
                                                                        (personal):</span>
                                                                    <div class="ml-auto">
                                                                        {{ $details['user']->phone_2 }}</div>
                                                                </li>
                                                            @endif
                                                            <span class="fw-600">Permanant Address</span>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">District:</span>
                                                                <div class="ml-auto">{{ $details['district'] }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Province:</span>
                                                                <div class="ml-auto">{{ $details['province'] }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Address:</span>
                                                                <div class="ml-auto">{{ $details['address'] }}
                                                                </div>
                                                            </li>
                                                            <span class="fw-600">Temporary Address</span>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">District:</span>
                                                                <div class="ml-auto">
                                                                    {{ $details['temp_district'] }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Province:</span>
                                                                <div class="ml-auto">
                                                                    {{ $details['temp_province'] }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Address:</span>
                                                                <div class="ml-auto">
                                                                    {{ $details['temp_address'] }}
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card bshadow mt-4">
                                                    <div class="card-header bg-white">
                                                        <p class="fw-600 mb-0">Office Details</p>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Employee Id:</span>
                                                                <div class="ml-auto">
                                                                    {{ $details['user']->employee_id }}</div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Department:</span>
                                                                <div class="ml-auto">
                                                                    {{ $details['user']->department->name }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Designation:</span>
                                                                <div class="ml-auto">
                                                                    {{ $details['user']->userDesignation->name }}</div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Email (Official):</span>
                                                                <div class="ml-auto">{{ $details['user']->email }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Phone (Office):</span>
                                                                <div class="ml-auto">{{ $details['user']->phone }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Date of
                                                                    Interview:</span>
                                                                <div class="ml-auto">
                                                                    {{ date('d M, Y', strtotime($details['user']->interview_date)) }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Joined On:</span>
                                                                <div class="ml-auto">
                                                                    {{ date('d M, Y', strtotime($details['user']->joined)) }}
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item staff_details">
                                                                <span class="font-weight-semibold">Allow Overtime:</span>
                                                                <div class="ml-auto">
                                                                    {{ $details['user']->allow_overtime == 'yes' ? 'Yes' : 'No' }}
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-documents" role="tabpanel"
                                        aria-labelledby="pills-documents-tab">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="row">
                                                <div
                                                    class="form-group  @if (isset($details['user']->profile_image)) col-md-9 @else col-md-12 @endif">
                                                    <label>Photo [jpg, jpeg, png]</label>
                                                    <input type="file" name="profile_image" class="form-control">
                                                </div>
                                                @error('profile_image')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                                @if (isset($details['user']->profile_image))
                                                    <div class="col-md-3">
                                                        <div class="custom-control custom-checkbox select-1">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck_profile_image" name="delete_profile_image"
                                                                value="delete_profile_image">
                                                            <label class="custom-control-label"
                                                                for="customCheck_profile_image"
                                                                title="Check for delete this image"></label>
                                                        </div>
                                                        <img class="img-thumbnail image_list img-fluid"
                                                            src="{{ asset('uploads/UserDocuments/thumbnail/' . $details['user']->profile_image) }}"
                                                            alt="No Image" width="100">
                                                    </div>
                                                @endif
                                                <!-- citizenship -->
                                                <div
                                                    class="form-group @if (isset($details['user']->citizenship)) col-md-9 @else col-md-12 @endif">
                                                    <label>Citizenship [pdf]</label>
                                                    <input type="file" class="form-control" name="citizenship">
                                                </div>
                                                @error('citizenship')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                                @if (isset($details['user']->citizenship))
                                                    <div class="col-md-3">
                                                        <div class="custom-control custom-checkbox select-1">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck_citizenship" name="delete_citizenship"
                                                                value="delete_citizenship">
                                                            <label class="custom-control-label"
                                                                for="customCheck_citizenship"
                                                                title="Check for delete"></label>
                                                        </div>
                                                        <a href="{{ asset('uploads/UserDocuments/' . $details['user']->citizenship) }}"
                                                            target="_blank">
                                                            <img class="img-thumbnail image_list img-fluid"
                                                                src="{{ asset('theme/images/pdf.png') }}" alt="No Image"
                                                                width="100">
                                                        </a>
                                                    </div>
                                                @endif
                                                <!-- CV -->
                                                <div
                                                    class="form-group @if (isset($details['user']->cv)) col-md-9 @else col-md-12 @endif">
                                                    <label>CV / Resume [pdf]</label>
                                                    <input type="file" class="form-control" name="cv">
                                                </div>
                                                @error('cv')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                                @if (isset($details['user']->cv))
                                                    <div class="col-md-3">
                                                        <div class="custom-control custom-checkbox select-1">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck_cv" name="delete_cv" value="delete_cv">
                                                            <label class="custom-control-label" for="customCheck_cv"
                                                                title="Check for delete"></label>
                                                        </div>
                                                        <a href="{{ asset('uploads/UserDocuments/' . $details['user']->cv) }}"
                                                            target="_blank">
                                                            <img class="img-thumbnail image_list img-fluid"
                                                                src="{{ asset('theme/images/pdf.png') }}" alt="No Image"
                                                                width="100">
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-leave-detail" role="tabpanel"
                                        aria-labelledby="pills-leave-detail-tab">
                                        <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">First</th>
                                                        <th scope="col">Last</th>
                                                        <th scope="col">Handle</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Mark</td>
                                                        <td>Otto</td>
                                                        <td>@mdo</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">2</th>
                                                        <td>Jacob</td>
                                                        <td>Thornton</td>
                                                        <td>@fat</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">3</th>
                                                        <td colspan="2">Larry the Bird</td>
                                                        <td>@twitter</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="row">


        </div>
    </div>
@endsection
@section('modals')
@endsection
@section('css')
@endsection
@section('js')
@endsection
