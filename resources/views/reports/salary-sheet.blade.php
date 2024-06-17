@extends('layouts.layout')
@section('title','Salary Sheet')

@section('content')
    @php
        $days_name=['Sun','Mon','Tue','Wed', 'Thurs', 'Fri','Sat'];
    @endphp
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="newHrBreadCumb">

                        <h5 class="mb-0">Salary Sheet (@if($is_real) Real @else Expected @endif)</h5>


                </div>
            </div>
            <div class="col-md-12">
            <div class="custom-wrapper">
                    <div class="title-2">

                        <div class="title-right">
                            @if(isset($next['show']) && $next['show'])
                                <a href="{{route('reports.salary-sheet',['year'=>$next['year'],'month'=>$next['month']])}}" class="btn btn-success btn-sm pull-right">NEXT</a>
                            @else
                                <a href="#" class="btn btn-success btn-sm pull-right disabled">NEXT</a>
                            @endif
                            <a href="{{route('reports.salary-sheet',['year'=>$prev['year'],'month'=>$prev['month']])}}" class="btn btn-success btn-sm pull-right">PREV</a>
                        </div>
                    </div>

            </div>
                <div class="custom-wrapper">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-sm table-user table-bordered" style="width:100%;">
                            <thead class="thead-dark" style="--sec_header_color : {{ $settings->sec_header_color }};">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Joined</th>
                                    <th scope="col">Expected Yearly Salary</th>
                                    <th scope="col">Salary</th>
                                    <th scope="col">Total Days</th>
                                    <th scope="col">Present Days</th>
                                    <th scope="col">Paid Leave</th>
                                    <th scope="col">Unpaid Leave</th>
                                    <th scope="col">Payable Days</th>
                                    <th scope="col">Gross Salary Payable</th>
                                    <th scope="col">Total Payable</th>
                                    <th scope="col">TDS</th>
                                    <th scope="col">Net Payable</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $user)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $user['name'] }} </td>
                                        <td>{{ $user['joined'] }} </td>
                                        <td>{{ $user['expected_yearly_income'] }} </td>
                                        <td>{{ $user['salary'] }} </td>
                                        <td>{{ $user['work_days'] }} </td>
                                        <td>{{ $user['present_days'] }} </td>
                                        <td>{{ $user['paid_leave'] }} </td>
                                        <td>{{ $user['unpaid_leave'] }}</td>
                                        <td>{{ $user['payable_days'] }} </td>
                                        <td>{{ $user['gross_salary_payable'] }} </td>
                                        <td>{{ $user['total_payable'] }} </td>
                                        <td>{{ $user['tds'] }}</td>
                                        <td>{{ $user['net_payable'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(!$is_real)
                    <div class="custom-wrapper">
                        <a href="{{route('salary.pay.salary',['year'=>$current['year'],'month'=>$current['month']])}}" class="btn btn-success">PAY</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="modal-change-holiday" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="changeHolidayLabel" aria-hidden="true">

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
        $(document).ready(function() {
            $('table').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
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
