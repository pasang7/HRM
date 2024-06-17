@extends('layouts.layout')
@section('title', 'Travel History')
@section('content')
    @php
    $days_name = ['Sun', 'Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat'];
    @endphp
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Travel History</h5>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-sm" style="width:100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Staff</th>
                                    <th scope="col">Name of Program</th>
                                    <th scope="col">Advance (NPR)</th>
                                    <th scope="col">Travel Plan</th>
                                    <th scope="col">Reviewed</th>
                                    <th scope="col">Approved</th>
                                    <th scope="col">Rejected</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($travel_histories as $k => $history)
                                    <?php
                                    $interval = $history->to->diff($history->from);
                                    $travel_days = $interval->format('%a') + 1;
                                    ?>
                                    <tr>
                                        <th scope="row">{{ $k + 1 }}</th>
                                        <td>
                                            @if ($history->from != $history->to)
                                                {{ date('d M, Y', strtotime($history->from)) }} to
                                                {{ date('d M, Y', strtotime($history->to)) }}
                                            @else
                                                {{ date('d M, Y', strtotime($history->from)) }}
                                            @endif
                                        </td>
                                        <td>{{ $history->user->name }}</td>
                                        <td>{{ $history->program_name }} <br>
                                            <span>Place: </span>{{ $history->place }}
                                        </td>

                                        <td>{{ $history->advance_taken }}</td>
                                        <td>
                                            <a href="{{ asset('uploads/Travel/' . $history->travel_plan) }}"
                                                target="_blank" title="View File">
                                                <img src="{{ asset('theme/images/pdf.png') }}" width="30">
                                            </a>
                                        </td>
                                        <td>
                                            @if ($history->is_reviewed)
                                                <span> By: {{ $history->recommendedUser->name }}</span><br>
                                                <span>Date:
                                                    {{ date('d M, Y', strtotime($history->reviewed_date)) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($history->is_reviewed && $history->is_accepted)
                                                <span> By: {{ $history->approvedUser->name }}</span><br>
                                                <span>Date:
                                                    {{ date('d M, Y', strtotime($history->approved_date)) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($history->is_reviewed && $history->is_rejected)
                                                <span> By: {{ $history->approvedUser->name }}</span><br>
                                                <span>Date:
                                                    {{ date('d M, Y', strtotime($history->approved_date)) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$history->is_accepted && !$history->is_reviewed && !$history->is_rejected)
                                                <span class="badge badge-info">Pending</span>
                                            @elseif($history->is_reviewed && $history->is_accepted)
                                                <span class="badge badge-success">Reviewed and Approved</span>
                                            @elseif($history->is_reviewed && $history->is_rejected)
                                                <span class="badge badge-danger">Reviewed, Rejected</span>
                                            @elseif($history->is_reviewed && !$history->is_accepted)
                                                <span class="badge badge-success">Reviewed</span>
                                            @elseif($history->is_rejected)
                                                <span class="badge badge-danger">Rejected</span>
                                            @endif

                                        </td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-travel-id="{{ $history->id }}"
                                                data-toggle="modal"
                                                data-target="#historyModal{{ $k }}">View</button>
                                            <!-- Review Modal -->
                                            <div class="modal fade" id="historyModal{{ $k }}" tabindex="-1"
                                                role="dialog" aria-labelledby="historyModal{{ $k }}Label"
                                                aria-hidden="true">
                                                <div class="modal-lg modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="historyModal{{ $k }}Label">Approve Travel
                                                                Request</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <dl class="dl-horizontal row">
                                                                <dt class="col-sm-3">Staff Name:</dt>
                                                                <dd class="col-sm-9">
                                                                    {{ $history->user->name }}</dd>
                                                                <dt class="col-sm-3">Department:</dt>
                                                                <dd class="col-sm-9">
                                                                    {{ $history->user->department->name }}</dd>
                                                                <dt class="col-sm-3">Designation:</dt>
                                                                <dd class="col-sm-9">
                                                                    {{ $history->user->userDesignation->name }}
                                                                </dd>
                                                                <dt class="col-sm-3">Name of Program:</dt>
                                                                <dd class="col-sm-9">
                                                                    {{ $history->program_name }}</dd>
                                                                <dt class="col-sm-3">Place:</dt>
                                                                <dd class="col-sm-9">{{ $history->place }}
                                                                </dd>
                                                                <dt class="col-sm-3">Purpose of Visiting:</dt>
                                                                <dd class="col-sm-9">{{ $history->purpose }}
                                                                </dd>
                                                                <dt class="col-sm-3">Travelling Via:</dt>
                                                                <dd class="col-sm-9">
                                                                    {{ $history->travel_mode }}</dd>
                                                                @if ($history->travel_mode == 'others')
                                                                    <dt class="col-sm-3">Other Travel Mode:</dt>
                                                                    <dd class="col-sm-9">
                                                                        {{ $history->other_travel_mode }}</dd>
                                                                    <dt class="col-sm-3">Remarks:</dt>
                                                                    <dd class="col-sm-9">
                                                                        {{ $history->justification }}</dd>
                                                                @endif
                                                                <dt class="col-sm-3">Travel Date:</dt>
                                                                <dd class="col-sm-9">
                                                                    {{ date('d M,Y', strtotime($history->from)) }}
                                                                    to
                                                                    {{ date('d M,Y', strtotime($history->to)) }}
                                                                    ({{ $travel_days }} days)
                                                                </dd>
                                                                <dt class="col-sm-3">Travel Plan:</dt>
                                                                <dd class="col-sm-9"><a
                                                                        href="{{ asset('uploads/Travel/' . $history->travel_plan) }}"
                                                                        target="_blank"
                                                                        class="text-info">{{ $history->travel_plan }}</a>
                                                                </dd>
                                                            </dl>
                                                            <div class="row">
                                                                <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                                                                    <table class="table" cellspacing="0"
                                                                        width="100%" style="border: 0;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Accommodation Day :</td>
                                                                                <td>{{ $history->accommodation_day }}
                                                                                    day(s)</td>
                                                                                <td>Per Diem: </td>
                                                                                <td>{{ $history->accommodation_per_diem }}
                                                                                </td>
                                                                                <td class="text-info">Total: </td>
                                                                                <td>{{ $history->accommodation_total }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Daily Allowance Day :</td>
                                                                                <td>{{ $history->daily_allowance_day }}
                                                                                    day(s)</td>
                                                                                <td>Per Diem: </td>
                                                                                <td>{{ $history->daily_allowance_per_diem }}
                                                                                </td>
                                                                                <td class="text-info">Total: </td>
                                                                                <td>{{ $history->daily_allowance_total }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Daily Allowance Day :</td>
                                                                                <td>{{ $history->contingency_day }}
                                                                                    day(s)</td>
                                                                                <td>Per Diem: </td>
                                                                                <td>{{ $history->contingency_per_diem }}
                                                                                </td>
                                                                                <td class="text-info">Total: </td>
                                                                                <td>{{ $history->contingency_total }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">Advance
                                                                                    Taken(Total)</td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td style="font-weight: bold;">
                                                                                    {{ $history->advance_taken }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <dl class="dl-horizontal row">
                                                                @if ($history->remarks)
                                                                    <dt class="col-sm-3">Contingency Remarks</dt>
                                                                    <dd class="col-sm-9">
                                                                        {{ $history->remarks }}</dd>
                                                                @endif
                                                                <div class="col-4">
                                                                    <div class="row">
                                                                        <dt class="col-12">Submitted By</dt>
                                                                        <dd class="col-12">
                                                                            {{ $history->user->name }}</dd>
                                                                        <dd class="col-12">
                                                                            {{ $history->user->userDesignation->name }},
                                                                            {{ $history->user->department->name }}
                                                                        </dd>
                                                                        <dt class="col-12">
                                                                            <hr>
                                                                        </dt>
                                                                        <dd class="col-12"> Date:
                                                                            {{ date('d M, Y', strtotime($history->submitted_date)) }}
                                                                        </dd>
                                                                    </div>
                                                                </div>
                                                                @if ($history->is_reviewed)
                                                                    <div class="col-4">
                                                                        <div class="row">
                                                                            <dt class="col-12">Recommended By</dt>
                                                                            <dd class="col-12">
                                                                                {{ $history->recommendedUser->name }}
                                                                            </dd>
                                                                            <dd class="col-12">
                                                                                {{ $history->recommendedUser->userDesignation->name }},
                                                                                {{ $history->recommendedUser->department->name }}
                                                                            </dd>
                                                                            <dt class="col-12">
                                                                                <hr>
                                                                            </dt>
                                                                            <dd class="col-12"> Date:
                                                                                {{ date('d M, Y', strtotime($history->recommended_date)) }}
                                                                            </dd>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if ($history->is_accepted)
                                                                    <div class="col-4">
                                                                        <div class="row">
                                                                            <dt class="col-12">Approved By</dt>
                                                                            <dd class="col-12">
                                                                                {{ $history->approvedUser->name }}
                                                                            </dd>
                                                                            <dd class="col-12">
                                                                                {{ $history->approvedUser->userDesignation->name }},
                                                                                {{ $history->recommendedUser->department->name }}
                                                                            </dd>
                                                                            <dt class="col-12">
                                                                                <hr>
                                                                            </dt>
                                                                            <dd class="col-12"> Date:
                                                                                {{ date('d M, Y', strtotime($history->approved_date)) }}
                                                                            </dd>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </dl>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    <div class="modal fade" id="modal-change-holiday" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="changeHolidayLabel" aria-hidden="true"></div>
@endsection
@section('css')
    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <!-- Datatable -->


@endsection
@section('js')
    <!-- Datatable -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js "></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <!-- Datatable -->
    <script>
        const reject_url = "{{ route('travel.request.reject') }}"
        const accept_paid_url = "{{ route('leave.request.accept.paid') }}"

        $(document).on('click', '.btn-reject', function(e) {
            e.preventDefault()
            var travel_id = $(this).data('travel-id')
            Swal.queue([{
                title: 'Reject Travel Request',
                confirmButtonText: 'Accept',
                showCancelButton: true,
                text: 'You are about to reject the travel request!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    $.ajax({
                            url: reject_url,
                            method: "POST",
                            data: {
                                'travel_id': travel_id
                            },
                            beforeSend: function(xhr) {}
                        })
                        .done(function(data) {
                            var res = JSON.parse(data)
                            if (res.status) {
                                if (res.reload) {
                                    showAlert('success', res.title, res.text)
                                    location.reload();
                                } else {
                                    showAlert('success', res.title, res.text)
                                }
                            } else {
                                if (res.reload) {
                                    showAlert('error', res.title, res.text)
                                    location.reload();

                                } else {
                                    showAlert('error', res.title, res.text)
                                }
                            }
                        });
                }
            }])
        })
        $(document).on('submit', '#form-change-holiday', function(e) {
            e.preventDefault()
            var form = $(this)
            var url = form.data('action')
            var data = form.serialize()
            $.ajax({
                    url: url,
                    method: "POST",
                    data: data,
                    beforeSend: function(xhr) {

                    }
                })
                .done(function(data) {
                    var res = JSON.parse(data)
                    if (res.status) {
                        $('#modal-change-holiday').modal('hide')
                    } else {
                        alert(res.message)
                    }

                });
        })
    </script>
    <script>
        $(document).ready(function() {
            $('table').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                buttons: [
                    'pageLength',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
        });
    </script>
@endsection
