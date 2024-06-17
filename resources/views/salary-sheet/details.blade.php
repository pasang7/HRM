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
            <div class="col-lg-12 mb-2">
                <div class="newHrBreadCumb">

                    <h5 class="mb-0">Salary Sheet (Expected)</h5>


                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                    <table class="table table-hover table-sm table-user table-bordered" style="width:100%;">
                        <thead >
                        <tr class="">
                            <td style="background: #fff;" colspan="6"></td>
                            <td class="text-center fw-600" colspan="15">Annual Salary</td>
                            <td class="text-center fw-600" colspan="9">Monthly Salary</td>
                        </tr>
                        <tr>
                            <td>#</td>
                            <td>Name</td>
                            <td>Designation</td>
                            <td>Gender</td>
                            <td>Joined</td>
                            {{-- <td>End Date</td> --}}
                            {{-- <td>Gap</td> --}}
                            <td>Monthly Basic Salary</td>
                            {{-- Allowance section --}}
                            {{-- @forelse ($allowances as $allow)
                            <td>{{ $allow->name }}</td>
                            @empty  @endforelse--}}


                            <td>Expected <br> Annual Salary</td>
                            <td>Employee PF ({{ $employee_pf_value * 100 }}%)</td>
                            <td>Gratuity ({{ $gratuityValue * 100 }}%)</td>
                            <td> Gross Salary</td>
                            <td>Employer PF ({{ $employer_pf_value * 100 }}%)</td>
                            <td>CIT Self Contribution</td>
                            <td>Gratuity Deposit ({{ $gratuityValue * 100 }}%)</td>
                            <td>Total Deposit</td>
                            <td>Allowable Deduction</td>
                            {{-- Insurance section --}}
                            <td>Total Deduction</td>
                            <td>Taxable Salary</td>
                            <td> 1% Social Security*</td>
                            <td> Total Rem Tax</td>
                            <td> Rebate @ 10%</td>
                            <td> Total Annual Tax</td>

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
                        @foreach($sheetReport->details as $u=>$report)
                            <tr>
                                <td>{{ $u + 1 }}</td>
                                <td>{{ $report->user->name }}</td>
                                <td>{{ $report->user->userDesignation->name }}</td>
                                <td>{{ $report->user->gender==1? 'Male' : 'Female' }}</td>
                                <td>{{ date('d/m/Y', strtotime($report->user->joined)) }}</td>
                                {{-- <td>{{ $report['end_date'] }}</td> --}}
                                {{-- <td>{{ $report['gap'] }}</td> --}}
                                <td>{{ $report->monthly_salary }}</td>
                                {{-- @forelse($user['userAllowance'] as $allowance)
                                <td>{{ $allowance }}</td>
                                @empty
                                @endforelse --}}
                                <td>{{ $report->annual_salary }}</td>
                                <td>{{ $report->annually_employee_pf }}</td>
                                <td>{{ $report->gratuity }}</td>
                                <td>{{ $report->grossSalary }}</td>
                                <td>{{ $report->annually_employer_pf }}</td>
                                <td>{{ $report->cit }}</td>
                                <td>{{ $report->gratuity }}</td>
                                <td>{{ $report->totDep }}</td>
                                <td>{{ $report->allowable_deduction }}</td>
                                {{-- Insurance section --}}
                                <td>{{ $report->total_deduction }}</td>
                                <td>{{ $report->taxable_salary }}</td>
                                <td>{{ $report->social_security_tax }}</td>
                                <td>{{ $report->annual_rem_tax }}</td>
                                <td>{{ $report->rebate }}</td>
                                <td>{{ $report->total_annual_tax }}</td>

                                <td>{{ $report->work_days }}</td>
                                <td>{{ $report->paid_leave }}</td>
                                <td>{{ $report->unpaid_leave }}</td>
                                <td>{{ $report->payable_days }}</td>
                                <td>{{ $report->payable_salary }}</td>
                                <td>{{ $report->monthly_employee_pf }}</td>
                                <td>{{ $report->citMonthly }}</td>
                                <td>{{ $report->monthly_tds }}</td>
                                <td>{{ round($report->net_salary) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
        $(document).ready(function () {
            $('table').DataTable({
                dom: 'Bfrtip',
                lengthMenu: [
                    [20, 30, 50, -1],
                    ['20 rows', '30 rows', '50 rows', 'Show all']
                ],
                buttons: [
                    'pageLength',
                    'excelHtml5',
                ]
            });
        });
    </script>
@endsection
