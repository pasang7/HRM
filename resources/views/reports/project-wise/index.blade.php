@extends('layouts.layout')
@section('title', 'Project wise report')

@section('content')
    @php
    $days_name = ['Sun', 'Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat'];
    @endphp
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5 class="mb-0">Project Wise Report</h5>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-sm table-user table-bordered" style="width:100%;">
                            <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Project</th>
                                    <th scope="col">Worked Hr</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <a href="{{ route('reports.project-wise.reports', $project['slug']) }}">

                                                @php
                                                    $title=wordwrap($project['name'],80,"<br />\n", false);
                                                @endphp
                                                @php echo "$title" @endphp
                                            </a>
                                        </td>
                                        <td>
                                            <?php
                                            $hour = floor($project['worked_time'] / 60);
                                            $min = $project['worked_time'] - $hour * 60;
                                            ?>
                                            @if ($hour != 0)
                                                {{ $hour }}hr
                                            @else
                                            0
                                            @endif
                                            @if ($min != 0)
                                                {{ $min }}min
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
        $(document).ready(function() {
            $('table').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                "columns": [
                    null,
                    null, {
                        "width": "300px"
                    },
                ],
                buttons: [
                    'pageLength',
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
        });
    </script>
@endsection
