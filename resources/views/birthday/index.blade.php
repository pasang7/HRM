@extends('layouts.layout')
@section('title','Birthday')

@section('content')
    @php 
        $days_name=['Sun','Mon','Tue','Wed', 'Thurs', 'Fri','Sat'];
    @endphp
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                       <div class="newHrBreadCumb">
                        <h5 class="mb-0">Birthday (Today)</h5>
                    </div>
                </div>
                <div class="col-lg-12">
<div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-sm table-user" style="width:100%;">
                            <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Gender</th>

                                    <th scope="col">EID</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">DOB</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($birthday['today'])
                                    @foreach($birthday['today'] as $user)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->gender==0?'M':'F' }}</td>
                                            <td>{{ $user->employee_id }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->address }}</td>
                                            <td>{{ $user->department->name }}</td>
                                            <td>{{ $user->dob->format('Y/m/d') }}</td>
                                            
                                        </tr>
                                    @endforeach
                                @endisset
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
