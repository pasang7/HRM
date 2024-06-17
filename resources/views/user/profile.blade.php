@extends('layouts.layout')
@section('title', 'My Profile')

@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>My Profile</h5>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12">
                    
                            <div class="custom-wrapper text-center profile-pic-upload">
                                <form action="{{ route('profile.image-upload') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @if ($details['user']->profile_image)
                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox select-1">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="customCheck_profile_image" name="delete_profile_image"
                                                    value="delete_profile_image">
                                                <label class="custom-control-label" for="customCheck_profile_image"
                                                    title="Check for delete this image">Check to Remove</label>
                                            </div>
                                        </div>
                                        <div class="profile-pic">
                                            <img src="{{ asset('uploads/UserDocuments/thumbnail/' . $details['user']->profile_image) }}"
                                                class="img-fluid rounded-circle" alt="No Image" />
                                            <input type="file" name="profile_image" class="browse-img">
                                        </div>
                                    @else
                                        <div class="profile-pic">
                                            <img src="{{ asset('theme/images/user.png') }}">
                                            <input type="file" name="profile_image" class="browse-img">
                                        </div>
                                    @endif
                                    <h2 class="text-dark">Hi, {{ $details['user']->name }}</h2>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button type="submit" class="btn btn-sm btn-primary btn-upload" style="--main_header_color : {{ $settings->main_header_color }};">Upload
                                                file</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="custom-wrapper margin-top-2">
                                <div class="hrprosubHead">
                                    <h5>Office Detail</h5>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Interview Date</td>
                                                        <td>{{ date('d M, Y', strtotime($details['user']->interview_date)) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Joined Date</td>
                                                        <td>{{ date('d M, Y', strtotime($details['user']->joined)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Department</td>
                                                        <td>{{ $details['user']->department->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Role</td>
                                                        <td>{{ $details['user']->userRole->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Designation</td>
                                                        <td>{{ $details['user']->userDesignation->name }} </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                          
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 col-sm-8 col-xs-12">
                    <div class=" personal-details-wrapper">
                     
                            <div class="custom-wrapper">
                                <div class="hrprosubHead">
                                    <h5>Personal Detail</h5>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Name</td>
                                                        <td>{{ $details['user']->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date of Birth</td>
                                                        <td>{{ date('d M, Y', strtotime($details['user']->dob)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Gender</td>
                                                        <td>{{ $details['user']->gender == '0' ? 'Female' : 'Male' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Marrital Status</td>
                                                        <td>{{ $details['user']->is_married == '0' ? 'Unmarried' : 'Married' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Religion</td>
                                                        <td>{{ $details['user']->userReligion->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Blood Group</td>
                                                        <td>{{ $details['user']->bloodGroup->name }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Email</td>
                                                        <td>{{ $details['user']->email }} @if ($details['user']->email_2)
                                                                , {{ $details['user']->email_2 }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Phone</td>
                                                        <td>{{ $details['user']->phone }} @if ($details['user']->phone_2)
                                                                , {{ $details['user']->phone_2 }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Permanent Address</td>
                                                        <td>{{ $details['district'] }}, {{ $details['province'] }},
                                                            {{ $details['address'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Temprorary Address</td>
                                                        <td>{{ $details['temp_district'] }},
                                                            {{ $details['temp_province'] }},
                                                            {{ $details['temp_address'] }}</td>
                                                    </tr>
                                                    @if ($details['user']->has_pan == 'yes')
                                                        <tr>
                                                            <td>PAN Number</td>
                                                            <td>{{ $details['user']->pan_no }}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($details['user']->has_ssf == 'yes')
                                                        <tr>
                                                            <td>SSF</td>
                                                            <td>{{ $details['user']->ssf_no }}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($details['user']->has_pf == 'yes')
                                                        <tr>
                                                            <td>PF Number</td>
                                                            <td>{{ $details['user']->pf_no }}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($details['user']->has_cit == 'yes')
                                                        <tr>
                                                            <td>CIT Number</td>
                                                            <td>{{ $details['user']->cit_no }}</td>
                                                        </tr>
                                                    @endif
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

@endsection
@section('modals')
    <div class="modal fade" id="modal-change-holiday" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="changeHolidayLabel" aria-hidden="true">

    </div>
@endsection

@section('css')

@endsection

@section('js')

@endsection
