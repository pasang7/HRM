@extends('layouts.layout')
@section('title','Salary Sheet')

@section('content')
    @php 
        $days_name=['Sun','Mon','Tue','Wed', 'Thurs', 'Fri','Sat'];
        $employee_pf_value = $companySetting->employee_pf_value ? $companySetting->employee_pf_value : 0.1;
        $employer_pf_value = $companySetting->employer_pf_value ? $companySetting->employer_pf_value : 0.2;
        $gratuityValue = $companySetting->gratuity_value ? $companySetting->gratuity_value : 0.0833;
    @endphp
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
            <div class="custom-wrapper">
                    <div class="title-2">
                        <div class="title-left">
                            <p class="fw-600 mb-0">Salary Sheet (@if($is_real) Real @else Expected @endif)</p>
                        </div>
                        {{-- <div class="title-right">
                            @if(isset($next['show']) && $next['show'])
                                <a href="{{route('reports.salary-sheet',['year'=>$next['year'],'month'=>$next['month']])}}" class="btn btn-success btn-sm pull-right">NEXT</a>
                            @else 
                                <a href="#" class="btn btn-success btn-sm pull-right disabled">NEXT</a>
                            @endif
                            <a href="{{route('reports.salary-sheet',['year'=>$prev['year'],'month'=>$prev['month']])}}" class="btn btn-success btn-sm pull-right">PREV</a>
                        </div> --}}
                    </div>
            
            </div>
                <div class="custom-wrapper">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-sm table-user table-bordered" style="width:100%;">
                            <thead class="thead-dark" style="--sec_header_color : {{ $settings->sec_header_color }};">
                                <tr class="">
                                    <td style="background: #fff;" colspan="6"></td>
                                    <td class="text-center fw-600" colspan="{{ 15 + count($allowances)}}">Annual Salary</td>
                                    <td class="text-center fw-600" colspan="9">Monthly Salary</td>
                                </tr>
                                <tr class="salary-head text-white">
                                    <td>#</td>
                                    <td>Name</td>
                                    <td>Designation</td>
                                    <td>Gender</td>
                                    <td>Joined</td>
                                    {{-- <td>End Date</td> --}}
                                    {{-- <td>Gap</td> --}}
                                    <td>Monthly Basic Salary</td>
                                    @forelse($allowances as $allowance)
                                    <td>{{ $allowance->name }}</td>
                                    @empty

                                    @endforelse
                                    {{-- Allowance section --}}
                                    <td>Expected <br> Annual Salary</td>
                                    <td>Employee PF ({{ $employee_pf_value * 100 }}%)</td>
                                    <td>Gratuity ({{ $gratuityValue * 100 }}%)</td>
                                    <td> Gross Salary</td>
                                    <td>Employer PF ({{ $employer_pf_value * 100 }}%)</td>
                                    <td>CIT Self Contribution</td>
                                    <td>Gratuity Deposit ({{ $gratuityValue * 100 }}%)</td>
                                    <td>Total Deposit </td>
                                    <td>Allowable Deduction</td>
                                    {{-- Insurance section --}}
                                    <td>Total Deduction</td>
                                    <td>Taxable Salary</td>
                                    <td> 1% Social Security* </td>
                                    <td> Total Rem Tax </td>
                                    <td> Rebate @ 10% </td>
                                    <td> Total Annual Tax </td>

                                    <td>Total <br> Working Days</td>
                                    <td>Paid Leave</td>
                                    <td>Unpaid Leave</td>
                                    <td>Payable Days</td>
                                    <td>Monthly <br> Basic Sal</td>
                                    <td>Employee PF ({{ $employee_pf_value * 100 }}%)</td>
                                    <td>CIT Deduction Monthly</td>
                                    <td>Monthly TDS Deduction</td>
                                    <td>Net Salary Payable</td>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($data as $u=>$user)
                               <tr>
                                   <td>{{ $u + 1 }}</td>
                                   <td>{{ $user['name'] }}</td>
                                   <td>{{ $user['designation'] }}</td>
                                   <td>{{ $user['gender'] }}</td>
                                   <td>{{ $user['joinedDate'] }}</td>
                                   {{-- <td>{{ $user['end_date'] }}</td> --}}
                                   {{-- <td>{{ $user['gap'] }}</td> --}}
                                   <td>{{ $user['basic_salary'] }}</td>
                                   @forelse($user['userAllowance'] as $allowance)
                                    <td>{{ $allowance }}</td>
                                    @empty

                                    @endforelse
                                   <td>{{ $user['annual_salary'] }}</td>
                                   <td>{{ $user['annual_employee_pf'] }}</td>
                                   <td>{{ $user['gratuity'] }}</td>
                                   <td>{{ $user['grossSalary'] }}</td>
                                   <td>{{ $user['an_employer_pf'] }}</td>
                                   <td>{{ $user['cit'] }}</td>
                                   <td>{{ $user['gratuity'] }}</td>
                                   <td>{{ $user['totDep'] }}</td>
                                   <td>{{ $user['allowable_deduction'] }}</td>
                                    {{-- Insurance section --}}
                                   <td>{{ $user['total_deduction'] }}</td>
                                   <td>{{ $user['taxable_salary'] }}</td>
                                   <td>{{ $user['social_security_tax'] }}</td>
                                   <td>{{ $user['annual_rem_tax'] }}</td>
                                   <td>{{ $user['rebate'] }}</td>
                                   <td>{{ $user['total_annual_tax'] }}</td>

                                   <td>{{ $user['work_days'] }}</td>
                                   <td>{{ $user['paid_leave'] }}</td>
                                   <td>{{ $user['unpaid_leave'] }}</td>
                                   <td>{{ $user['payable_days'] }}</td>
                                   <td>{{ $user['payable_salary'] }}</td>
                                   <td>{{ $user['monthly_employee_pf'] }}</td>
                                   <td>{{ $user['citMonthly'] }}</td>
                                   <td>{{ $user['monthly_tds'] }}</td>
                                   <td>{{ round($user['net_salary']) }}</td>
                               </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(!$is_real)
                    <div class="custom-wrapper">
                        <a href="" class="btn btn-success">PAY</a>
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
    <link rel="stylesheet" href="{{ asset('theme/css/salary_dataTables.min.css') }}">
    <!-- Datatable -->
@endsection
@section('js')
    <!-- Datatable -->
    <script src="{{ asset('theme/js/salary_dataTables.min.js') }}"></script> 
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
                dom: 'Bfrtip',
                lengthMenu: [
                    [ 20, 30, 50, -1 ],
                    [ '20 rows', '30 rows', '50 rows', 'Show all' ]
                ],
                buttons: [
                    'pageLength',
                    'excelHtml5',
                ]
            });
        });
    </script>
@endsection
