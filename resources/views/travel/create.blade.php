@extends('layouts.layout')
@section('title', 'Travel Request')
@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Travel Authorization Form</h5>
                    </div>
                </div>
                <div class="col-lg-12 mt-2">
                    <div class="newHrFormGrp bg-lgrey">
                        <form autocomplete="off" method="POST" action="{{ route('travel.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="hrprosubHead">
                                        <h5>Employee Information</h5>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4 col-sm-12">
                                    <label>Employee Name</label>
                                    <input type="text" class="form-control custom-form-control" value="{{ $user->name }}"
                                        readonly>
                                </div>
                                <input type="hidden" name="user_id" value="{{ $user->id }}" required>

                                <div class="col-lg-4 col-md-4 col-sm-12 form-group">
                                    <label>Designation</label>
                                    <input type="text" class="form-control custom-form-control" placeholder="Full Name"
                                        value="{{ $designation }}" readonly>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="required">Select your
                                            Shift</label>
                                        <select name="shift_id" class="form-control custom-select" placeholder="Shifts">
                                            @foreach ($user->department->shifts as $s => $shift)
                                                <option value="{{ $shift->id }}">
                                                    {{ date('h:i A', strtotime($shift->clockin)) }}
                                                    to
                                                    {{ date('h:i A', strtotime($shift->clockout)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('shift_id')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <div class="hrprosubHead">
                                        <h5>Travelling Information</h5>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 form-group">
                                    <label for="program_name" class="required">Travelling For (Name of
                                        Program)</label>
                                    <input type="text" name="program_name" class="form-control custom-form-control"
                                        aria-describedby="program_nameHelp" placeholder="Name of Program"
                                        value="{{ old('program_name') }}">
                                    @error('program_name')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-sm-12 form-group">
                                    <label for="from" class="required">From</label>
                                    <input type="text" name="from" id="start_from" class="form-control custom-form-control"
                                        placeholder="Start From" value="{{ old('from') }}">
                                    @error('from')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-sm-12 form-group">
                                    <label for="to" class="required">To</label>
                                    <input type="text" name="to" id="end_to" class="form-control custom-form-control"
                                        placeholder="End To" value="{{ old('to') }}">
                                    @error('to')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-12 col-sm-12 form-group">
                                    <label for="place" class="required">Place of
                                        Field Visit</label>
                                    <input type="text" name="place" class="form-control custom-form-control"
                                        aria-describedby="placeHelp" placeholder="Place Name" value="{{ old('place') }}">
                                    @error('place')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-12 col-sm-12 form-group">
                                    <label for="purpose" class="required">Purpose
                                        of Visit</label>
                                    <textarea name="purpose" class="form-control custom-form-control" aria-describedby="purposeHelp"
                                        placeholder="Purpose of Visit"
                                        style="height: 100px;">{{ old('purpose') }}</textarea>
                                    @error('purpose')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="required">Travel Plan for
                                            Field Visit
                                            [.pdf]</label>
                                        <input type="file" name="travel_plan" class="form-control">
                                    </div>
                                    @error('travel_plan')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-sm-12 form-group">
                                    <label for="travel_mode" class="required">Travel Mode</label>
                                    <br>
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-checkbox mr-3">
                                            <input type="checkbox" class="custom-control-input" id="travelplane"
                                                name="travel_mode[]" value="taxi">
                                            <label class="custom-control-label mb-0 pt-1" for="travelplane">Plane</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mr-3">
                                            <input type="checkbox" class="custom-control-input" id="travelbus"
                                                name="travel_mode[]" value="bus">
                                            <label class="custom-control-label mb-0 pt-1" for="travelbus">Bus</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="traveltaxi"
                                                name="travel_mode[]" value="taxi">
                                            <label class="custom-control-label mb-0 pt-1" for="traveltaxi">Taxi</label>
                                        </div>
                                    </div>
                                    {{-- <label class="checkbox-inline"><input type="checkbox" value="plane"
                                            name="">&nbsp;Plane</label>&nbsp;
                                    <label class="checkbox-inline"><input type="checkbox" value="bus"
                                            name="travel_mode[]">&nbsp;Bus</label>&nbsp;
                                    <label class="checkbox-inline"><input type="checkbox" value="taxi"
                                            name="travel_mode[]">&nbsp;Taxi</label>&nbsp; --}}
                                </div>
                                <div class="col-lg-6 col-sm-12 form-group">
                                    <label>If you have other travel mode:</label>
                                    <input type="text" class="form-control" name="other_travel_mode"
                                        placeholder="Other Travel Mode">
                                </div>
                                {{-- <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <label>Other Travel Mode</label>

                                </div> --}}
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                    <label>Remarks & Justification for Travel mode</label>
                                    <textarea class="form-control" rows="8"  name="justification" placeholder="Justification"></textarea>
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <div class="hrprosubHead">
                                        <h5>Advance Request</h5>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-4 col-sm-12 form-group">
                                            <div class="bg-white p-3 ">
                                                <h6 class="text-dark font-weight-bold">Accomodation</h6>
                                                <div class="row p-t-10">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 form-group">
                                                        <label class="required">No of
                                                            Days</label>
                                                        <input type="number" name="accommodation_day" class="form-control"
                                                            id="acc_day" placeholder="0" step=".1">
                                                        @error('accommodation_day')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 form-group">
                                                        <label class="required">Per
                                                            DIEM</label>
                                                        <input type="number" name="accommodation_per_diem"
                                                            class="form-control" id="acc_per_diem" placeholder="0"
                                                            step=".01">
                                                        @error('accommodation_per_diem')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 form-group">
                                                        <label>Total</label>
                                                        <input type="text" name="accommodation_total" class="form-control"
                                                            placeholder="0" value="" id="acc_tot" readonly>
                                                        @error('accommodation_total')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-lg-6 col-md-4 col-sm-12 form-group">
                                            <div class="bg-white p-3">
                                                <h6 class="text-dark font-weight-bold">Daily
                                                    Allowance (DA)</h6>
                                                <div class="row  p-t-10">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 form-group">
                                                        <label class="required">No of
                                                            Days</label>
                                                        <input type="number" name="daily_allowance_day"
                                                            class="form-control" id="da_day" placeholder="0" step=".1">
                                                        @error('daily_allowance_day')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 form-group">
                                                        <label class="required">Per
                                                            DIEM</label>
                                                        <input type="number" name="daily_allowance_per_diem"
                                                            class="form-control" id="da_per_diem" placeholder="0"
                                                            step=".01">
                                                        @error('daily_allowance_per_diem')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 form-group">
                                                        <label>Total</label>
                                                        <input type="text" name="daily_allowance_total"
                                                            class="form-control" id="da_tot" placeholder="0" value=""
                                                            readonly>
                                                        @error('daily_allowance_total')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-lg-12 col-md-4 col-sm-12 form-group">
                                            <div class="bg-white p-3">
                                                <h6 class="text-dark font-weight-bold">Travel</h6>
                                                <div class="row p-t-10">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 form-group">
                                                        <label class="required">No of  Days</label>
                                                        <input type="number" name="contingency_day" class="form-control"
                                                            id="cont_day" placeholder="0" step=".1 " required>
                                                        @error('contingency_day')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 form-group">
                                                        <label class="required">Per
                                                            DIEM</label>
                                                        <input type="number" name="contingency_per_diem"
                                                            class="form-control" id="cont_per_diem" placeholder="0"
                                                            step=".01" required>
                                                        @error('contingency_per_diem')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 form-group">
                                                        <label>Total</label>
                                                        <input type="text" name="contingency_total" class="form-control"
                                                            id="cont_tot" placeholder="0" readonly>
                                                        @error('contingency_total')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-12 col-sm-12 form-group">
                                                        <label class="required">Remarks</label>
                                                        <textarea type="text" rows="8" name="remarks" class="form-control"></textarea>
                                                        @error('remarks')
                                                            <small class="form-text text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 form-group p-t-10">
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-secondary" style="--main_header_color : {{ $settings->main_header_color }};"
                                                        onclick="calculateAdvance()" title="Refresh Advance Total">Calculate
                                                        Advance Taken</a>
                                                </div>
                                                <div class="col-lg-12 form-group" id="advDiv" style="display: none;">
                                                    <label>Advance Taken (TOTAL)</label>
                                                    &nbsp;&nbsp;
                                                    <input type="text" name="advance_taken" class="form-control" id="adv_taken"
                                                        placeholder="0" readonly required>
                                                    @error('advance_taken')
                                                        <small class="form-text text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-lg-12 d-flex justify-content-end">
                                            <!-- <div class="d-flex align-items-center justify-content-end"> -->
                                                <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm btn-create"><i data-feather="send"></i>
                                                    Request
                                                    Now</button>
                                            <!-- </div> -->
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/travel_request.js') }}"></script>
@endsection
@section('css')
    <style type="text/css">
        .required:after {
            content: " *";
            color: red;
        }

    </style>
@endsection
