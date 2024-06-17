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
                        <table class="table table-sm maintable" style="width:100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Staff</th>
                                    <th scope="col">Travel Overview</th>
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
                                        <td>{{ $travel_request->user->name }}</td>
                                        <td>
                                            <span class="leave_user">{{ $travel_request->program_name }}</span><br>
                                            <span>Place: </span>
                                            @php $place = wordwrap($travel_request->place,10,"<br>\n"); @endphp
                                            @php echo $place @endphp
                                            @if ($travel_request->from != $travel_request->to)
                                            From: {{ date('d M, Y', strtotime($travel_request->from)) }} <br>
                                            To: {{ date('d M, Y', strtotime($travel_request->to)) }}<br>
                                            @else
                                            {{ date('d M, Y', strtotime($travel_request->from)) }}<br>
                                            @endif
                                            <span>Advance (NPR): </span>{{ $travel_request->advance_taken }}<br>
                                            <span>Travel Plan: </span>
                                            <a href="{{ asset('uploads/Travel/' . $travel_request->travel_plan) }}"
                                                target="_blank" title="View File">
                                                <img src="{{ asset('theme/images/pdf.png') }}" width="20">
                                            </a>
                                        </td>
                                        <td>
                                            @if ($travel_request->is_reviewed)
                                                <span>Reviewed By: {{ $travel_request->recommendedUser->name }}</span><br>
                                                <span>Reviewed Date:
                                                    {{ date('d M, Y', strtotime($travel_request->recommended_date)) }}</span>
                                            @endif
                                            @if ($travel_request->is_reviewed && $travel_request->is_accepted)
                                               <br> <span>Approved By: {{ $travel_request->approvedUser->name }}</span><br>
                                                <span>Approved Date:
                                                    {{ date('d M, Y', strtotime($travel_request->approved_date)) }}</span>
                                            @endif
                                            @if ($travel_request->is_reviewed && $travel_request->is_rejected)
                                                <br><span>Rejected By: {{ $travel_request->approvedUser->name }}</span><br>
                                                <span>Rejected Date:
                                                    {{ date('d M, Y', strtotime($travel_request->approved_date)) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$travel_request->is_accepted && !$travel_request->is_reviewed && !$travel_request->is_rejected)
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
                                            @if ($travel_request->is_reviewed && !$travel_request->is_rejected)
                                                <button class="btn btn-success btn-sm"
                                                    data-travel-id="{{ $travel_request->id }}" data-toggle="modal"
                                                    data-target="#approveModal{{ $k }}">
                                                    @if ($travel_request->is_reviewed && !$travel_request->is_accepted)
                                                        Approve Now
                                                    @else
                                                        View
                                                    @endif
                                                </button>
                                                <!-- Review Modal -->
                                                <div class="modal fade" id="approveModal{{ $k }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="approveModal{{ $k }}Label"
                                                    aria-hidden="true">
                                                    <div class="modal-xl modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="approveModal{{ $k }}Label">Travel Request</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('travel.request.approve') }}" method="post">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <dl class="dl-horizontal row">
                                                                        <dt class="col-sm-3">Staff Name:</dt>
                                                                        <dd class="col-sm-9">
                                                                            {{ $travel_request->user->name }}</dd>
                                                                        <dt class="col-sm-3">Department:</dt>
                                                                        <dd class="col-sm-3">
                                                                            {{ $travel_request->user->department->name }}
                                                                        </dd>
                                                                        <dt class="col-sm-3">Designation:</dt>
                                                                        <dd class="col-sm-3">
                                                                            {{ $travel_request->user->userDesignation->name }}
                                                                        </dd>
                                                                        <dt class="col-sm-3">Name of Program:</dt>
                                                                        <dd class="col-sm-3">
                                                                            {{ $travel_request->program_name }}</dd>
                                                                        <dt class="col-sm-3">Place:</dt>
                                                                        <dd class="col-sm-3">
                                                                            @php $place = wordwrap($travel_request->place,15,"<br>\n"); @endphp
                                                                            @php echo $place @endphp
                                                                        </dd>
                                                                        <dt class="col-sm-3">Purpose of Visiting:</dt>
                                                                        <dd class="col-sm-3">
                                                                            @php
                                                                            $purpose = wordwrap($travel_request->purpose,40,"<br>\n");
                                                                            @endphp
                                                                            @php echo $purpose @endphp
                                                                        </dd>
                                                                        <dt class="col-sm-3">Travelling Via:</dt>
                                                                        <dd class="col-sm-3">
                                                                            {{ $travel_request->travel_mode }}</dd>
                                                                        @if ($travel_request->other_travel_mode)
                                                                            <dt class="col-sm-3">Other Travel Mode:
                                                                            </dt>
                                                                            <dd class="col-sm-9">
                                                                                {{ $travel_request->other_travel_mode }}
                                                                            </dd>
                                                                            <dt class="col-sm-3">Remarks:</dt>
                                                                            <dd class="col-sm-9">
                                                                                @php
                                                                                    $justification = wordwrap($travel_request->justification,80,"<br>\n");
                                                                                @endphp
                                                                                @php echo $justification @endphp
                                                                            </dd>
                                                                        @endif
                                                                        <dt class="col-sm-3">Travel Plan:</dt>
                                                                        <dd class="col-sm-9"><a
                                                                                href="{{ asset('uploads/Travel/' . $travel_request->travel_plan) }}"
                                                                                target="_blank"
                                                                                class="text-info">{{ $travel_request->travel_plan }}</a>
                                                                        </dd>
                                                                        <dt class="col-sm-3">Travel Date:</dt>
                                                                        <dd class="col-sm-9">
                                                                            {{ date('d M,Y', strtotime($travel_request->from)) }}
                                                                            to
                                                                            {{ date('d M,Y', strtotime($travel_request->to)) }}
                                                                            ({{ $travel_days }} days)</dd>
                                                                        <dd class="col-sm-12">
                                                                            <table class="table table-sm" width="100%">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th scope="col">Date</th>
                                                                                        <th class="text-center">Action
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                $loop=1;
                                                                                $begin=\Carbon\Carbon::parse($travel_request->from);
                                                                                    $end=\Carbon\Carbon::parse($travel_request->to);
                                                                                    while (strtotime($begin) <= strtotime($end)) {
                                                                                    $day = $begin->format('w');
                                                                                            $prev_travel = \App\Models\Attendance::where('user_id',$travel_request->user->id)
                                                                                            ->where('date',date ("Y-m-d", strtotime($begin)))->where('is_travel', 1)
                                                                                            ->first();
                                                                                            // if(!empty($prev_travel)){
                                                                                                echo '<tr><td>';
                                                                                                echo $begin->format('F d, Y') . ' (' . $begin->format('l').')';
                                                                                                echo '</td>';
                                                                                                ?>
                                                                                    <td class="text-center">
                                                                                        <input type="radio" name="x[{{ $begin->format('Y/m/d') }}]" value="1" class="radio-custom radio-green"  title="Include in Travel Day" checked> &nbsp; Include in
                                                                                        Travel day &nbsp;
                                                                                        <input type="radio" name="x[{{ $begin->format('Y/m/d') }}]" value="2" class="radio-custom radio-black" title="Exclude from Travel day" @if(!$prev_travel && $travel_request->is_accepted == 1) checked @endif>&nbsp;
                                                                                        Exclude from Travel day &nbsp;
                                                                                    </td>
                                                                                    <?php
                                                                                        // }
                                                                                    $begin = date ("Y-m-d", strtotime("+1 day", strtotime($begin)));
                                                                                    $begin = \Carbon\Carbon::parse($begin);
                                                                                    $loop++;
                                                                                    }
                                                                                ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </dd>
                                                                    </dl>
                                                                    <div class="row">
                                                                        <dt class="col-sm-2">Accommodation:</dt>
                                                                        <dd class="col-sm-2">
                                                                            {{ $travel_request->accommodation_day }} day(s)
                                                                        </dd>
                                                                        <dt class="col-sm-2">Per Diem: </dt>
                                                                        <dd class="col-sm-2">
                                                                            {{ $travel_request->accommodation_per_diem }}
                                                                        </dd>
                                                                        <dt class="col-sm-2">Total: </dt>
                                                                        <dd class="col-sm-2">
                                                                            {{ $travel_request->accommodation_total }}
                                                                        </dd>
                                                                        <dt class="col-sm-2">Daily Allowance:</dt>
                                                                        <dd class="col-sm-2">
                                                                            {{ $travel_request->daily_allowance_day }} day(s)
                                                                        </dd>
                                                                        <dt class="col-sm-2">Per Diem: </dt>
                                                                        <dd class="col-sm-2">
                                                                            {{ $travel_request->daily_allowance_per_diem }}
                                                                        </dd>
                                                                        <dt class="col-sm-2">Total: </dt>
                                                                        <dd class="col-sm-2">
                                                                            {{ $travel_request->daily_allowance_total }}
                                                                        </dd>
                                                                        <dt class="col-sm-2">Travel:</dt>
                                                                        <dd class="col-sm-2">
                                                                            {{ $travel_request->contingency_day }} day(s)
                                                                        </dd>
                                                                        <dt class="col-sm-2">Per Diem: </dt>
                                                                        <dd class="col-sm-2">
                                                                            {{ $travel_request->contingency_per_diem }}
                                                                        </dd>
                                                                        <dt class="col-sm-2">Total: </dt>
                                                                        <dd class="col-sm-2">
                                                                            {{ $travel_request->contingency_total }}
                                                                        </dd>
                                                                        <dt class="col-sm-7"></dt>
                                                                        <dt class="col-sm-3">Advance Taken(Total): </dt>
                                                                        <dt class="col-sm-2">
                                                                            {{ $travel_request->advance_taken }}
                                                                        </dt>
                                                                    </div>
                                                                    <dl class="dl-horizontal row margin-top-2">
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
                                                                                <dd class="col-12">
                                                                                    {{ $travel_request->user->name }}<br>
                                                                                    {{ $travel_request->user->userDesignation->name }},<br>
                                                                                    {{ $travel_request->recommendedUser->department->name }}
                                                                                </dd>
                                                                                <dt class="col-12">
                                                                                    <hr>
                                                                                </dt>
                                                                                <dd class="col-12"> Date:
                                                                                    {{ date('d M, Y', strtotime($travel_request->submitted_date)) }}
                                                                                </dd>
                                                                            </div>
                                                                        </div>
                                                                        @if ($travel_request->is_reviewed)
                                                                            <div class="col-lg-4 col-sm-12 margin-top-2">
                                                                                <div class="row">
                                                                                    <dt class="col-12">Recommended
                                                                                        By
                                                                                    </dt>
                                                                                    <dd class="col-12">
                                                                                        {{ $travel_request->recommendedUser->name }}
                                                                                        <br>
                                                                                        {{ $travel_request->recommendedUser->userDesignation->name }},<br>
                                                                                        {{ $travel_request->recommendedUser->department->name }}
                                                                                    </dd>
                                                                                    <dt class="col-12">
                                                                                        <hr>
                                                                                    </dt>
                                                                                    <dd class="col-12">
                                                                                        {{ $travel_request->recommended_remarks ? 'Remarks: ' . $travel_request->recommended_remarks : '' }}
                                                                                        <br>
                                                                                        Date:
                                                                                        {{ date('d M, Y', strtotime($travel_request->recommended_date)) }}
                                                                                    </dd>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if ($travel_request->is_accepted)
                                                                            <div class="col-lg-4 col-sm-12 margin-top-2">
                                                                                <div class="row">
                                                                                    <dt class="col-12">Approved By
                                                                                    </dt>
                                                                                    <dd class="col-12">
                                                                                        {{ $travel_request->approvedUser->name }}
                                                                                        <br>
                                                                                        {{ $travel_request->approvedUser->userDesignation->name }},<br>
                                                                                        {{ $travel_request->recommendedUser->department->name }}
                                                                                    </dd>
                                                                                    <dt class="col-12">
                                                                                        <hr>
                                                                                    </dt>
                                                                                    <dd class="col-12">
                                                                                        {{ $travel_request->accepted_remarks ? 'Remarks: ' . $travel_request->accepted_remarks : '' }}
                                                                                        <br>
                                                                                        Date:
                                                                                        {{ date('d M, Y', strtotime($travel_request->approved_date)) }}
                                                                                    </dd>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </dl>
                                                                    <hr width="100%">
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-sm-12">
                                                                            @if ($travel_request->is_reviewed && !$travel_request->is_accepted)
                                                                                <input type="hidden" name="travel_id"
                                                                                    value="{{ $travel_request->id }}"
                                                                                    readonly>
                                                                                <div class="form-group">
                                                                                    <label>Remarks [if any]</label>
                                                                                    <textarea type="text"
                                                                                        name="accepted_remarks"
                                                                                        class="form-control"></textarea>
                                                                                </div>
                                                                                <div class="text-right">
                                                                                    <button type="submit"
                                                                                        class="btn btn-success">Approve</button>
                                                                                    <a href="javascript:void(0);"
                                                                                        style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary"
                                                                                        data-dismiss="modal">Close</a>

                                                                                </div>
                                                                                @else

                                                                                <div class="text-right">
                                                                                    <a href="javascript:void(0);"
                                                                                        style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary"
                                                                                        data-dismiss="modal">Close</a>

                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($travel_request->is_reviewed && !$travel_request->is_accepted && !$travel_request->is_rejected)
                                                <button class="btn btn-danger btn-sm btn-reject"
                                                    data-travel-id="{{ $travel_request->id }}">Reject</button>
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
@section('js')
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
                    beforeSend: function(xhr) {}
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
            $('.maintable').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                lengthMenu: [
                    [20, 35, 50, -1],
                    ['20 rows', '35 rows', '50 rows', 'Show all']
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
