@extends('layouts.layout')
@section('title','Edit Leave Type')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Leave Type</div>

                    <div class="card-body">
                            <form autocomplete="off" method="POST" action="{{ route('leave-type.update') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $leave_type->id }}">
                                <div class="form-group">
                                    <label for="days">Days</label>
                                    <input type="number" name="days" class="form-control" aria-describedby="daysHelp" placeholder="Days" value="{{ $leave_type->days }}" min=1 required>
                                    @error('days')
                                        <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror

                                </div>
                               
                                <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary">Update</button>
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
                "maxDate":moment().subtract(15, 'years')
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });
    </script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
