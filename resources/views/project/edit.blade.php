@extends('layouts.layout')
@section('title','Edit Project')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header header-bg" style="--sec_header_color: {{ $settings->sec_header_color }};">
                        <p class="mb-0 fw-600">Edit Project</p>
                        </div>

                    <div class="card-body bg-lgrey">
                            <form autocomplete="off" method="POST" action="{{ route('project.update') }}">
                                @csrf
                                <input type="hidden" name="slug" value="{{ $project->slug }}">

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="custom-form-control form-control" aria-describedby="nameHelp" placeholder="Name" value="{{ $project->name }}" required>
                                    @error('name')
                                        <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="deadline">Deadline</label>
                                    <input type="text" name="deadline" class="custom-form-control form-control" placeholder="Deadline" value="{{ $project->deadline->format('m/d/Y') }}" required>
                                    @error('deadline')
                                        <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="btn-create-wrapper">
                                    <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm btn-create">Create</button>
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
            $(document).ready(function() {
                $('input[name="deadline"]').daterangepicker({
                    "singleDatePicker": true,
                    "minDate": moment()
                }, function(start, end, label) {
                    
                });
               
            });
    </script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
