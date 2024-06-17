@extends('layouts.layout')
@section('title','Staff wise report')

@section('content')
    @php
        $days_name=['Sun','Mon','Tue','Wed', 'Thurs', 'Fri','Sat'];
    @endphp
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="newHrBreadCumb">
                        <h5>Staff Wise Report</h5>
                        <span  style="--main_header_color : {{ $settings->main_header_color }};">Staff's Name: <span class="important">{{$user->name}}</span></span>
                    </div>
                    <form method="GET" class="form-nepali-date-range " autocomplete="off">
                        <div class="d-flex align-items-center">

                            <input placeholder="Filter" name="filter" type="text" id="filter"
                                   class=" form-control"
                                   value="@if( isset($filter)){{$filter}}@endif" required="">


                            <button type="submit" class="btn btn-primary btn-sm h-100"
                                    style="--main_header_color : {{ $settings->main_header_color }}; width:120px; height: 45px !important; margin-left: 10px;">
                                Filter Now
                            </button>
                        </div>


                    </form>
                </div>
            </div>
            <div class="col-lg-12 ">
                <div class="custom-wrapper">

                    <div class="table-responsive" style="--main_header_color : {{ $settings->main_header_color }};">
                        <div class="staffname">
                            <div class="row">

                                <div class="col-6">

                                </div>
                            </div>
                        </div>

                    <table class="table table-sm table-user table-bordered" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Project</th>
                            <th>Other Title</th>
                            <th>Worked Hr</th>
                            <th>Descriptions</th>
                            <th>Remarks</th>
                            <th>File</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reports as $r=>$report)
                            <tr id={{ $r+1 }}>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$report->date->format('F d,Y')}}</td>
                                <td>
                                    @php $project_name = wordwrap($report->project->name,10,"<br>\n"); @endphp
                                    @php echo $project_name @endphp
                                </td>

                                <td>
                                    @php $other_title = wordwrap($report->title,10,"<br>\n"); @endphp
                                    @php echo $other_title @endphp
                                </td>
                                <td>
                                    <?php
                                    $hour = floor(($report->time) / 60);
                                    $min = $report->time - ($hour * 60);
                                    ?>
                                    @if($hour!=0)
                                        {{$hour}}hr

                                    @endif
                                    @if($min!=0)
                                        {{$min}}min
                                    @endif
                                </td>
                                <td>
                                    @php $description = wordwrap($report->description,25,"<br>\n"); @endphp
                                    @php echo $description @endphp
                                </td>
                                <td>
                                    @php $remark = wordwrap($report->remark,25,"<br>\n"); @endphp
                                    @php echo $remark @endphp
                                <td>

                                    @if($report->files)
                                        <a href="{{route('download.file',$report->files)}}" title="{{$report->files}}"><i data-feather="file"></i></a>
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

@section('css')
    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <!-- Datatable -->

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

    <style>
        #customHead {
            display: inline-block;
            padding-left: 20px;
            float: left;
        }

        #customHead select {
            font-size: 13px;
            background: #fff;
            padding: 6px 12px;
            height: 34px;
            color: #2b2f33;
            border: #dfe8f1 solid 1px;
        }
    </style>
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
    <!-- Date Range Picker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Date Range Picker -->

    <script>
        var url = "{{route('reports.staff-wise.reports',':id')}}"
        $(document).ready(function () {
            var select = '<label>Staff <select class="staff">'
            @foreach($staffs as $staff)
                select += '<option value="{{$staff["slug"]}}"@if($staff["slug"]===$slug) selected @endif>{{$staff["name"]}}</option>'
            @endforeach
                select += '</select><label>'
            $('table').DataTable({
                responsive: true,
                // dom: 'Bfrtip',
                dom: 'l<"#customHead">frtBip',
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                buttons: [
                    'pageLength',
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]


            });
            $(select).appendTo('#customHead')
            $('#filter').daterangepicker({
                autoClose: true,
                opens: 'left'
            });
            $(document).on('change', '.staff', function (e) {
                url = url.replace(':id', this.value);
                window.location.href = url;
                // console.log(link)
            })
        });
    </script>
@endsection
