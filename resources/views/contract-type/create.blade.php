@extends('layouts.layout')
@section('title','Create New Leave Type')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header header-bg" style="--sec_header_color: {{ $settings->sec_header_color }};">
                        <p class="fw-600 mb-0">Create Contract Type</p>
                    </div>

                    <div class="card-body bg-lgrey">
                            <form autocomplete="off" method="POST" action="{{ route('leave-type.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" aria-describedby="nameHelp" placeholder="Name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="days">Day</label>
                                    <input type="number" name="days" min=1 max="365" class="form-control" placeholder="Day" value="{{ old('days') }}" required>
                                    @error('days')
                                        <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-create">Create</button>
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
            function toggleX(x){
                checkbox = document.getElementById('checkall');
                checkbox.checked = false;
            }
            function toggle(source) {
                checkboxes = document.getElementsByName('permission[]');
                for(var i=0, n=checkboxes.length;i<n;i++) {
                    checkboxes[i].checked = source.checked;
                }
            }
            $('input[name="dob"]').daterangepicker({
                "singleDatePicker": true,
                "startDate": "11/29/2019",
                "endDate": "12/05/2019"
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });
    </script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
