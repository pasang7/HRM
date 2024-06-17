@extends('layouts.layout')
@section('title', 'My Report')

@section('content')
    @php
    $total_worked_time = 0;
    $projects = [];
    @endphp
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>My Report</h5>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Project</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Other Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Remark</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    @php
                                        $total_time = $report->time / 60;
                                        $hr = floor($total_time);
                                        $min = ($total_time - $hr) * 60;
                                        $total_worked_time += $total_time;

                                        if (array_key_exists($report->project->id, $projects)) {
                                            $projects[$report->project->id]['time'] += $report->time;
                                        } else {
                                            $projects[$report->project->id] = [
                                                'name' => $report->project->name,
                                                'time' => $report->time,
                                            ];
                                        }
                                        $desp = wordwrap($report->description,50,"<br>\n");
                                        $remark = wordwrap($report->remark,50,"<br>\n");
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ date('d M, Y', strtotime($report->date)) }}</td>
                                        <td style="white-space: break-spaces !important;">{{ $report->project->name }}</td>
                                        <td>{{ $hr }}hr {{ $min }}min</td>
                                        <td>{{ $report->title }}</td>
                                        <td>@php echo $desp; @endphp </td>
                                        <td>
                                            @php echo $remark; @endphp
                                        </td>
                                        <td>
                                            @if ($report->files)
                                                <a
                                                    href="{{ route('download.file', $report->files) }}">{{ $report->files }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4 ">
                    {{-- <div class="hrproTableHead">
                        <h5>Reports</h5>
                    </div> --}}
                    <div class="table-responsive mt-4"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Report On</th>
                                    <th>Time Spent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Total worked time(Report)</td>
                                    @php
                                        $hr = floor($total_worked_time);
                                        $min = ($total_worked_time - $hr) * 60;
                                    @endphp
                                    <td>{{ $hr }}hr {{ $min }}min</td>
                                </tr>
                                <tr>
                                    <td>Total worked time(Attendance)</td>
                                    <td>{{ $total_worked_time }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="table-responsive mt-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="w-75">Project</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    @php
                                        $total_time = $project['time'] / 60;
                                        $hr = floor($total_time);
                                        $min = ($total_time - $hr) * 60;
                                    @endphp
                                    <tr>
                                        <td>{{ $project['name'] }}</td>
                                        <td>{{ $hr }}hr {{ $min }}min</td>
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
        aria-labelledby="changeHolidayLabel" aria-hidden="true">
    </div>
@endsection

@section('js')
    <script>
        $(document).on('click', '.btn-change-holiday', function(e) {
            e.preventDefault()
            var id = $(this).data('id')
            $.ajax({
                    url: "{{ route('user.get-change-holiday-form') }}",
                    method: "POST",
                    data: {
                        'user_id': id
                    },
                    beforeSend: function(xhr) {
                    }
                })
                .done(function(data) {
                    var res = JSON.parse(data)
                    if (res.status) {
                        $('#modal-change-holiday').html(res.view)
                        $('#modal-change-holiday').modal('show')
                    } else {
                        alert(res.message)
                    }

                });
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
@endsection
