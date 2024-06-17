@extends('layouts.layout')
@section('title','Leave Types')

@section('content')
    @php 
        $days_name=['Sun','Mon','Tue','Wed', 'Thurs', 'Fri','Sat'];
    @endphp
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="custom-wrapper">
                    <div class="title-2">
                        <div class="title-left">
                            <p class="fw-600 mb-0">Leave Type</p>
                        </div>
                        <div class="title-right">
                            <a href="{{route('leave-type.create')}}" class="btn btn-sm btn-success pull-right">Create</a>
                        </div>
                    </div>

                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-bordered">
                            <thead class="thead-dark" style="--sec_header_color : {{ $settings->sec_header_color }};">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaves as $leave)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $leave->name }}</td>
                                        <td>{{ $leave->days }}</td>
                                        <td>
                                            <a href="{{ route('leave-type.edit',$leave->id) }}" data-id="{{ $leave->id }}" class="btn btn-success btn-sm">Edit</a>
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
<div class="modal fade" id="modal-change-holiday" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="changeHolidayLabel" aria-hidden="true">

</div>
@endsection

@section('js')
<script>

</script>
@endsection
