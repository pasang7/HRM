@extends('layouts.layout')
@section('title','Leave Types')
@section('content')
    @php
        $days_name=['Sun','Mon','Tue','Wed', 'Thurs', 'Fri','Sat'];
    @endphp
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 mb-2">
                       <div class="newHrBreadCumb">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Leave Type Setup</h5>
                            <a href="{{route('leave-type.create')}}" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-sm btn-primary pull-right"><i data-feather="plus"></i>Add Leave Type</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-3 pt-1">
            <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-bordered table-hover">
                            <thead >
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaves as $k=>$leave)
                                    <tr>
                                        <td>{{ $leave->name }} @if($leave->short_name) ({{ $leave->short_name }}) @endif</td>
                                        <td>{{ $leave->days }}</td>
                                        <td>
                                            <a href="{{ route('leave-type.edit',$leave->id) }}" data-id="{{ $leave->id }}"  class="btn btn-secondary btn-sm" style="--main_header_color : {{ $settings->main_header_color }};"><i data-feather="edit-2"></i>Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('modals')
<div class="modal fade" id="modal-change-holiday" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="changeHolidayLabel" aria-hidden="true"></div>
@endsection

@section('js')
<script>

</script>
@endsection
