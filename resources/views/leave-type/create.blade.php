@extends('layouts.layout')
@section('title', 'Create New Leave Type')

@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Create New Leave Type</h5>
                    </div>
                </div>
                <div class="col-lg-12 mt-2">
                    <div class="newHrFormGrp bg-lgrey">
                        <form autocomplete="off" method="POST" action="{{ route('leave-type.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" aria-describedby="nameHelp"
                                            placeholder="Name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <small class="form-text text-muted">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="short_name">Short Name</label>
                                        <input type="text" name="short_name" class="form-control" aria-describedby="short_nameHelp"
                                            placeholder="Name" value="{{ old('short_name') }}" >
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="days">Day</label>
                                        <input type="text" name="days" max="365" class="form-control"
                                            placeholder="Day" value="{{ old('days') }}" required>
                                        @error('days')
                                            <small class="form-text text-muted">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mb-3">
                                    <label class="required">Is Carry Forward?</label><br>
                                    <label class="radio-inline"><input type="radio" value="1" name="carry_forward">&nbsp;Yes</label>&nbsp;
                                    <label class="radio-inline"><input type="radio" value="0" name="carry_forward">&nbsp;No</label>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-create">Create</button>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
        $('input[name="dob"]').daterangepicker({
            "singleDatePicker": true,
            "startDate": "11/29/2019",
            "endDate": "12/05/2019"
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
    </script>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
