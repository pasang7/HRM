@extends('layouts.layout')
@section('title', 'Travel Request')
@section('content')
    @php
    $days_name = ['Sun', 'Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat'];
    @endphp
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Travel Request</h5>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                    <table class="table table-sm" style="width:100%;">
                            <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Staff</th>
                                    <th scope="col">Overview</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($travel_requests as $k => $travel_request)
                                    <?php
                                    $interval = $travel_request->to->diff($travel_request->from);
                                    $travel_days = $interval->format('%a') + 1;
                                    ?>
                                    <tr>
                                        <th scope="row">{{ $k + 1 }}</th>
                                        <td>
                                          {{$travel_request->user->name}}
                                        </td>
                                        <td>

                                            @php $program = wordwrap($travel_request->program_name,20,"<br>\n"); @endphp
                                            <span class="leave_user"> @php echo $program @endphp</span><br>
                                            <span>Place: </span>
                                            @php $place = wordwrap($travel_request->place,10,"<br>\n"); @endphp
                                            @php echo $place @endphp <br>
                                            @if ($travel_request->from != $travel_request->to)
                                               From: {{ date('d M, Y', strtotime($travel_request->from)) }}<br>
                                                To: {{ date('d M, Y', strtotime($travel_request->to)) }} <br>
                                            @else
                                                {{ date('d M, Y', strtotime($travel_request->from)) }} <br>
                                            @endif
                                            <span>Advance (NPR): </span>{{ $travel_request->advance_taken }}
                                            <br>
                                            <a href="{{ asset('uploads/Travel/' . $travel_request->travel_plan) }}"
                                                target="_blank" title="View File">
                                                <img src="{{ asset('theme/images/pdf.png') }}" width="20"> Travel Plan
                                            </a>
                                        </td>

                                        <td>
                                            @if ($travel_request->is_reviewed)
                                                <span>Reviewed By: {{ $travel_request->recommendedUser->name }}</span><br>
                                                <span>Reviewed Date:
                                                    {{ date('d M, Y', strtotime($travel_request->reviewed_date)) }}</span>
                                            @endif
                                            @if($travel_request->is_reviewed && $travel_request->is_accepted)
                                            <br><span> Approved By: {{ $travel_request->approvedUser->name }}</span><br>
                                                <span>Approved Date:
                                                    {{ date('d M, Y', strtotime($travel_request->approved_date)) }}</span>
                                            @endif
                                            @if($travel_request->is_reviewed && $travel_request->is_rejected)
                                            <br>
                                                <span>Rejected By: {{ $travel_request->approvedUser->name }}</span><br>
                                                <span>Rejected Date:
                                                    {{ date('d M, Y', strtotime($travel_request->approved_date)) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$travel_request->is_accepted && !$travel_request->is_reviewed && !$travel_request->is_rejected)
                                            <span class="badge badge-info">Pending</span>
                                            @elseif($travel_request->is_reviewed && $travel_request->is_accepted)
                                                <span class="badge badge-success">Reviewed and Approved</span>
                                            @elseif($travel_request->is_reviewed && $travel_request->is_rejected)
                                                    <span class="badge badge-danger">Reviewed, Rejected</span>
                                            @elseif($travel_request->is_reviewed && !$travel_request->is_accepted)
                                                <span class="badge badge-success">Reviewed</span>
                                            @elseif($travel_request->is_rejected)
                                                <span class="badge badge-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm"
                                                data-travel-id="{{ $travel_request->id }}" data-toggle="modal"
                                                data-target="#reviewModal{{ $k }}">@if (!$travel_request->is_reviewed && !$travel_request->is_rejected)
                                                Recommend Now @else View @endif</button>
                                            <!-- Review Modal -->
                                            <div class="modal fade" id="reviewModal{{ $k }}" tabindex="-1"
                                                role="dialog" aria-labelledby="reviewModal{{ $k }}Label"
                                                aria-hidden="true">
                                                <div class="modal-lg modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="reviewModal{{ $k }}Label">Travel
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
                                                                    {{ $travel_request->user->name }}</dd>
                                                                <dt class="col-sm-3">Department:</dt>
                                                                <dd class="col-sm-9">
                                                                    {{ $travel_request->user->department->name }}</dd>
                                                                <dt class="col-sm-3">Designation:</dt>
                                                                <dd class="col-sm-9">
                                                                    {{ $travel_request->user->userDesignation->name }}
                                                                </dd>
                                                                <dt class="col-sm-3">Name of Program:</dt>
                                                                <dd class="col-sm-9">
                                                                    {{ $travel_request->program_name }}</dd>
                                                                <dt class="col-sm-3">Place:</dt>
                                                                <dd class="col-sm-9">
                                                                    @php $place = wordwrap($travel_request->place,15,"<br>\n"); @endphp
                                                                    @php echo $place @endphp
                                                                </dd>
                                                                <dt class="col-sm-3">Purpose of Visiting:</dt>
                                                                <dd class="col-sm-9">
                                                                    @php
                                                                    $purpose = wordwrap($travel_request->purpose,60,"<br>\n");
                                                                    @endphp
                                                                    @php echo $purpose @endphp
                                                                </dd>
                                                                <dt class="col-sm-3">Travelling Mode:</dt>
                                                                <dd class="col-sm-9">
                                                                    {{ $travel_request->travel_mode }}</dd>
                                                                @if ($travel_request->other_travel_mode)
                                                                    <dt class="col-sm-3">Other Travel Mode:</dt>
                                                                    <dd class="col-sm-9">
                                                                        {{ $travel_request->other_travel_mode }}</dd>
                                                                    <dt class="col-sm-3">Remarks:</dt>
                                                                    <dd class="col-sm-9">
                                                                        @php
                                                                            $justification = wordwrap($travel_request->justification,80,"<br>\n");
                                                                        @endphp
                                                                        @php echo $justification @endphp
                                                                @endif
                                                                <dt class="col-sm-3">Travel Plan:</dt>
                                                                <dd class="col-sm-9"><a href="{{ asset('uploads/Travel/' . $travel_request->travel_plan) }}"
                                                                        target="_blank" class="text-info">{{ $travel_request->travel_plan }}</a>
                                                                </dd>
                                                                <dt class="col-sm-3">Travel Date:</dt>
                                                                <dd class="col-sm-9">
                                                                    {{ date('d M,Y', strtotime($travel_request->from)) }}
                                                                    to
                                                                    {{ date('d M,Y', strtotime($travel_request->to)) }}
                                                                    ({{ $travel_days }} days)</dd>
                                                            </dl>
                                                            <div class="row">
                                                                <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                                                                    <table class="table" cellspacing="0"
                                                                        width="100%" style="border: 0;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Accommodation Day :</td>
                                                                                <td>{{ $travel_request->accommodation_day }}
                                                                                    day(s)</td>
                                                                                <td>Per Diem: </td>
                                                                                <td>{{ $travel_request->accommodation_per_diem }}
                                                                                </td>
                                                                                <td class="text-info">Total: </td>
                                                                                <td>{{ $travel_request->accommodation_total }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Daily Allowance Day :</td>
                                                                                <td>{{ $travel_request->daily_allowance_day }}
                                                                                    day(s)</td>
                                                                                <td>Per Diem: </td>
                                                                                <td>{{ $travel_request->daily_allowance_per_diem }}
                                                                                </td>
                                                                                <td class="text-info">Total: </td>
                                                                                <td>{{ $travel_request->daily_allowance_total }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Daily Allowance Day :</td>
                                                                                <td>{{ $travel_request->contingency_day }}
                                                                                    day(s)</td>
                                                                                <td>Per Diem: </td>
                                                                                <td>{{ $travel_request->contingency_per_diem }}
                                                                                </td>
                                                                                <td class="text-info">Total: </td>
                                                                                <td>{{ $travel_request->contingency_total }}
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
                                                                                    {{ $travel_request->advance_taken }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <dl class="dl-horizontal row">
                                                                @if ($travel_request->remarks)
                                                                    <dt class="col-sm-3">Travel Remarks</dt>
                                                                    <dd class="col-sm-9">
                                                                        @php
                                                                            $remarks = wordwrap($travel_request->remarks,100,"<br>\n");
                                                                        @endphp
                                                                        @php echo $remarks @endphp
                                                                    </dd>
                                                                @endif
                                                                <div class="col-lg-4 col-sm-12 margin-top-2">
                                                                    <div class="row">
                                                                        <dt class="col-12">Submitted By</dt>
                                                                        <dd class="col-12 mb-0">
                                                                            {{ $travel_request->user->name }}<br>
                                                                            {{ $travel_request->user->userDesignation->name }},<br>
                                                                            {{ $travel_request->user->department->name }}
                                                                        </dd>
                                                                        <!-- <dd class="col-12">
                                                                            <hr>
                                                                        </dd> -->
                                                                        <dd class="col-12"> Date:
                                                                            {{ date('d M, Y', strtotime($travel_request->submitted_date)) }}
                                                                        </dd>
                                                                    </div>
                                                                </div>
                                                                @if($travel_request->is_reviewed)
                                                                    <div class="offset-lg-4 col-lg-4 col-sm-12 margin-top-2">
                                                                        <div class="row">
                                                                            <dt class="col-12">Recommended By</dt>
                                                                            <dd class="col-12 mb-0">
                                                                                {{ $travel_request->recommendedUser->name }}<br>
                                                                                {{ $travel_request->recommendedUser->userDesignation->name }},<br>
                                                                                {{ $travel_request->recommendedUser->department->name }}
                                                                            </dd>
                                                                            <!-- <dt class="col-12">
                                                                                <hr>
                                                                            </dt> -->
                                                                            <dd class="col-12"> Date:
                                                                                {{ date('d M, Y', strtotime($travel_request->recommended_date)) }}
                                                                            </dd>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if($travel_request->is_accepted)
                                                                    <div class="col-4">
                                                                        <div class="row">
                                                                            <dt class="col-12">Approved By</dt>
                                                                            <dd class="col-12">
                                                                                {{ $travel_request->approvedUser->name }}<br>
                                                                                {{ $travel_request->approvedUser->userDesignation->name }},<br>
                                                                                {{ $travel_request->recommendedUser->department->name }}
                                                                            </dd>
                                                                            <dt class="col-12">
                                                                                <hr>
                                                                            </dt>
                                                                            <dd class="col-12"> Date:
                                                                                {{ date('d M, Y', strtotime($travel_request->approved_date)) }}
                                                                            </dd>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </dl>
                                                            <hr width="100%">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-sm-12">
                                                            @if(!$travel_request->is_reviewed && !$travel_request->is_rejected)
                                                                <form action="{{ route('travel.request.recommend') }}" method="post">
                                                                @csrf
                                                                    <input type="hidden" name="travel_id" value="{{ $travel_request->id }}" readonly>
                                                                       <div class="form-group">
                                                                        <label>Remarks [if any]</label>
                                                                        <textarea type="text" name="recommended_remarks" class="form-control"></textarea>
                                                                       </div>
                                                                    <div class="text-right">
                                                                        <button type="submit" class="btn btn-success">Recommend Now</button>
                                                                        <a href="javascript:void(0);" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                                                    </div>
                                                                </form>
                                                            @endif

                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (!$travel_request->is_reviewed && !$travel_request->is_rejected)
                                                <button class="btn btn-danger btn-sm btn-reject" data-travel-id="{{ $travel_request->id }}">Reject</button>
                                            @endif
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
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        const accept_partial_url = "{{ route('leave.partial.grant') }}"
        $(document).on('click', '.grant', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: accept_partial_url,
                data: {
                    '_token': csrf_token,
                    'id': $(this).data("travel-id")
                },
                async: false,
                success: function(response) {
                    // console.log(response)
                    $('#leaveGrantModal').find('.modal-body').append(response)
                    $('#leaveGrantModal').modal('show');
                },
                error: function(response) {}
            });
        })
        $('#leaveGrantModal').on('hidden.bs.modal', function() {
            $('#leaveGrantModal').find('.modal-body').html('');
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
