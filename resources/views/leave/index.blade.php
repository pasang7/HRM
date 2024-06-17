@extends('layouts.layout')
@section('title', 'Leave Request')

@section('content')
    @php
    $days_name = ['Sun', 'Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat'];
    @endphp
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="newHrBreadCumb">
                        <h5>Leave Requests</h5>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table" cellspacing="0" width="100%" style="border: 0;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Leave Overview</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leave_requests as $k=>$leave_request)
                                    <?php
                                    $interval = $leave_request->to->diff($leave_request->from);
                                    $leave_days = $interval->format('%a') + 1;
                                    $i=1;
                                    ?>
                                    @if ($leave_request->user->first_approval_id == Auth::user()->id || $leave_request->user->sec_approval_id == Auth::user()->id || Auth::user()->role == 3|| Auth::user()->role == 1)
                                        <tr>
                                            <th scope="row">{{ $k+1 }}</th>
                                            <td><span class="leave_user">{{ $leave_request->user->name }}</span><br>
                                                @if ($leave_request->from != $leave_request->to)
                                                    From: {{ date('d M, Y', strtotime($leave_request->from)) }} <br>
                                                    To: {{ date('d M, Y', strtotime($leave_request->to)) }}  <br>
                                                @else
                                                    {{ date('d M, Y', strtotime($leave_request->from)) }} <br>
                                                @endif
                                                {{ $leave_request->type->name }}
                                                {{ $leave_request->leave_type_full ? '' : ' (Half)' }}<br>
                                               <span>Reason:</span>
                                                @php
                                                $reason = wordwrap($leave_request->description, 25, "<br />\n", false);
                                            @endphp
                                            @php echo "$reason"@endphp
                                            </td>

                                            <td>
                                                @if ($leave_request->is_reviewed)
                                                    <span>Reviewed By: {{ $leave_request->reviewedUser->name }}</span><br>
                                                    <span>Date:
                                                        {{ date('d M, Y', strtotime($leave_request->reviewed_date)) }}</span>
                                                @endif
                                                @if ($leave_request->is_reviewed && $leave_request->is_accepted)
                                                <br><br><span>Approved By: {{ $leave_request->approveUser->name }}</span><br>
                                                    <span>Date:
                                                        {{ date('d M, Y', strtotime($leave_request->approved_date)) }}</span>
                                                @endif

                                                @if ($leave_request->is_reviewed && $leave_request->is_rejected)
                                                <br><br><span>Rejected By: {{ $leave_request->approveUser->name }}</span><br>
                                                    <span>Date:
                                                        {{ date('d M, Y', strtotime($leave_request->approved_date)) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!$leave_request->is_accepted && !$leave_request->is_reviewed && !$leave_request->is_rejected)
                                                    <span class="badge badge-info">Pending</span>
                                                @elseif($leave_request->is_reviewed && $leave_request->is_accepted)
                                                    <span class="badge badge-success">Reviewed and Approved</span>
                                                @elseif($leave_request->is_reviewed && $leave_request->is_rejected)
                                                    <span class="badge badge-danger">Reviewed, Rejected</span>
                                                @elseif($leave_request->is_reviewed && !$leave_request->is_accepted)
                                                    <span class="badge badge-success">Reviewed</span>
                                                @elseif($leave_request->is_rejected)
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!$leave_request->is_rejected)
                                                @if ($leave_request->user->first_approval_id == Auth::user()->id)
                                                    @if (!$leave_request->is_reviewed && !$leave_request->is_accepted)
                                                        @if ($leave_days <= $setting->min_leave_days_for_review)
                                                            {{-- <button class="btn btn-success btn-sm btn-accept-paid" data-leave-id="{{ $leave_request->id }}">Grant(Paid)</button> --}}
                                                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#grant_paid_modal{{ $leave_request->user->id }}">Grant(Paid)</button>
                                                            <!-- Review Modal -->
                                                            <div class="modal fade" id="grant_paid_modal{{ $leave_request->user->id }}" tabindex="-1" role="dialog" aria-labelledby="grant_paid_modal{{ $leave_request->user->id }}Label" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="grant_paid_modal{{ $k }}Label">
                                                                                Accept Leave</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="col-md-12">
                                                                                <h6>
                                                                                    You are about to accept the leave request of <b>{{ $leave_request->user->name }}</b> as paid leave!
                                                                                </h6>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-outline-danger"
                                                                                data-dismiss="modal">No</button>
                                                                                <form action="{{ route('leave.request.accept.paid') }}" method="post">
                                                                                @csrf
                                                                                <input type="hidden" name="leave_id" value="{{ $leave_request->id }}" readonly>
                                                                                <button type="submit" class="btn btn-outline-primary" >Yes</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <button class="btn btn-success btn-sm btn-accept-unpaid" data-leave-id="{{ $leave_request->id }}">Grant(Unpaid)</button>
                                                            @if ($leave_request->from != $leave_request->to)
                                                                <button class="btn btn-info btn-sm grant" data-leave-id="{{ $leave_request->id }}">Grant(Custom)</button>
                                                            @endif
                                                        @else
                                                            @if (!$leave_request->is_reviewed)
                                                                <button class="btn btn-success btn-sm" data-leave-id="{{ $leave_request->id }}" data-toggle="modal" data-target="#reviewModal{{ $leave_request->user->id }}">Review
                                                                    Leave
                                                                </button>
                                                                <!-- Review Modal -->
                                                                <div class="modal fade" id="reviewModal{{ $leave_request->user->id }}" tabindex="-1" role="dialog" aria-labelledby="reviewModal{{ $leave_request->user->id }}Label" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="reviewModal{{ $k }}Label">
                                                                                    Review
                                                                                    Leave Request</h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="col-md-12">
                                                                                    <h6>Review leave of
                                                                                        <b>{{ $leave_request->user->name }}</b>
                                                                                        & send for approval?
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary"
                                                                                    data-dismiss="modal">No</button>
                                                                                @if (!$leave_request->is_reviewed && !$leave_request->is_rejected)
                                                                                    <form
                                                                                        action="{{ route('leave.request.review') }}"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        <input type="hidden" name="leave_id"
                                                                                            value="{{ $leave_request->id }}"
                                                                                            readonly>
                                                                                        <button type="submit"
                                                                                            class="btn btn-success">Yes</button>
                                                                                    </form>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (!$leave_request->is_reviewed)
                                                            <button class="btn btn-danger btn-sm btn-reject" data-leave-id="{{ $leave_request->id }}">Reject</button>
                                                        @endif
                                                    @endif
                                                @endif

                                                @if ($leave_request->user->sec_approval_id == Auth::user()->id)
                                                    @if ($leave_days > $setting->min_leave_days_for_review)
                                                        @if ($leave_request->is_reviewed && !$leave_request->is_accepted)
                                                            @if (!$leave_request->is_accepted && !$leave_request->is_rejected)
                                                                <button class="btn btn-danger btn-sm btn-reject" data-leave-id="{{ $leave_request->id }}">Reject</button>
                                                                <button class="btn btn-success btn-sm btn-accept-paid"
                                                                    data-leave-id="{{ $leave_request->id }}">Grant(Paid)</button>
                                                                <button class="btn btn-success btn-sm btn-accept-unpaid"
                                                                    data-leave-id="{{ $leave_request->id }}">Grant(Unpaid)</button>
                                                                @if ($leave_request->from != $leave_request->to)
                                                                    <button class="btn btn-info btn-sm grant"
                                                                        data-leave-id="{{ $leave_request->id }}">Grant(Custom)</button>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                                @endif
                                            </td>
                                        </tr>

                                    @endif

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
    <!-- Partial Modal -->
    <div class="modal fade" id="leaveGrantModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Leave</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
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
        const reject_url = "{{ route('leave.request.reject') }}"
        const accept_paid_url = "{{ route('leave.request.accept.paid') }}"
        const accept_unpaid_url = "{{ route('leave.request.accept.unpaid') }}"

        $(document).on('click', '.btn-reject', function(e) {
            e.preventDefault()
            var leave_id = $(this).data('leave-id')
            Swal.queue([{
                title: 'Reject Leave',
                confirmButtonText: 'Accept',
                showCancelButton: true,
                text: 'You are about to reject the leave request!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    $.ajax({
                            url: reject_url,
                            method: "POST",
                            data: {
                                'leave_id': leave_id
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
        $(document).on('click', '.btn-accept-paid', function(e) {
            e.preventDefault()
            var leave_id = $(this).data('leave-id')
            Swal.queue([{
                title: 'Accept Leave',
                confirmButtonText: 'Accept',
                showCancelButton: true,
                text: 'You are about to accept the leave request as paid leave!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    $.ajax({
                            url: accept_paid_url,
                            method: "POST",
                            data: {
                                'leave_id': leave_id
                            },
                            beforeSend: function(xhr) {

                            }
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
        $(document).on('click', '.btn-accept-unpaid', function(e) {
            e.preventDefault()
            var leave_id = $(this).data('leave-id')
            Swal.queue([{
                title: 'Accept Leave',
                confirmButtonText: 'Accept',
                showCancelButton: true,
                text: 'You are about to accept the leave request as unpaid leave!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    $.ajax({
                            url: accept_unpaid_url,
                            method: "POST",
                            data: {
                                'leave_id': leave_id
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
                    'id': $(this).data("leave-id")
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
