@extends('layouts.layout')
@section('title', 'Create Project')

@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Create Project</h5>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="newHrFormGrp bg-lgrey p-3"    style="--main_header_color : {{ $settings->main_header_color }};">
                        <form autocomplete="off" method="POST" action="{{ route('project.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="custom-form-control form-control"
                                        aria-describedby="nameHelp" placeholder="Name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class=" col-lg-6 form-group">
                                    <label for="deadline">Deadline</label>
                                    <input type="text" name="deadline" class="custom-form-control form-control"
                                        placeholder="Deadline" value="{{ old('deadline') }}" required  style="--main_header_color : {{ $settings->main_header_color }};">
                                    @error('deadline')
                                        <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label for="department_id">Department</label>

                                    @if ($errors->any())
                                        <select class="custom-form-control form-control multiple-select"
                                            name="department_id[]" required multiple="multiple">
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    @if (old('department_id') && in_array($department->id, old('department_id'))) selected @endif>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <small class="form-text text-muted">{{ $message }}</small>
                                        @enderror
                                    @else
                                        <select class="custom-form-control form-control multiple-select"
                                            name="department_id[]" required multiple="multiple">
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-lg-12">
                                    <div class="btn-create-wrapper d-flex align-items-center justify-content-end">
                                        <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm btn-create">Create Now</button>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
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
        $(document).ready(function() {
            $('input[name="deadline"]').daterangepicker({
                "singleDatePicker": true,
                "minDate": moment()
            }, function(start, end, label) {

            });
            $('.multiple-select').select2();
        });
    </script>
@endsection
@section('css')
    <style type="">
        .select2-container{
                                                                                                                                                                    border:none!important;
                                                                                                                                                                    width: 100%!important;
                                                                                                                                                                    border-radius: 10px!important;
                                                                                                                                                                }
                                                                                                                                                                .select2-container--default.select2-container--focus .select2-selection--multiple {
                                                                                                                                                                /*border: solid black 1px;*/
                                                                                                                                                                border:solid #dcdcdc 1px!important;
                                                                                                                                                                border-radius: 10px!important;
                                                                                                                                                            }
                                                                                                                                                            
                                            </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
