@extends('layouts.layout')
@section('title', 'Income Tax')

@section('content')
    @php
    $days_name = ['Sun', 'Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat'];
    @endphp
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5 class="mb-0">Income Tax</h5>
                    </div>
                </div>
                <div class="col-lg-12 mt-3 pt-1">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};" >
                        <table class="table table-sm table-user table-bordered" style="width:100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="w-75">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($income_taxes as $k => $income_taxe)
                                    <?php
                                    $ss_tax = \App\Models\SsTaxSlab::where('income_tax_id', $income_taxe->id)->first();
                                    ?>

                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $income_taxe->name }}</td>
                                        <td>
                                            <a href="javascript:void(0);" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary btn-sm mr-2"
                                                data-toggle="modal" data-target="#ssTaxModal{{ $k }}">Social
                                                Security 1%
                                                Tax</a>
                                            <!-- Review Modal -->
                                            <div class="modal fade" id="ssTaxModal{{ $k }}" tabindex="-1"
                                                role="dialog" aria-labelledby="ssTaxModal{{ $k }}Label"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="ssTaxModal{{ $k }}Label">1%
                                                                Social Security
                                                            </h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-md-12">
                                                                <form
                                                                    action="{{ route('income-tax.ss.update', $ss_tax->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="income_tax_id"
                                                                        value="{{ $income_taxe->id }}" readonly>
                                                                    <div class="form-group row">
                                                                        <label
                                                                            class="col-3 col-form-label required">Amount</label>
                                                                        <div class="col-9">
                                                                            <input class="form-control" name="amount"
                                                                                type="number" placeholder="Amount"
                                                                                value="{{ old('amount', isset($ss_tax->amount) ? $ss_tax->amount : '') }}"
                                                                                required autofocus />
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong class="error-name"></strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-3 col-form-label required">Percent
                                                                        </label>
                                                                        <div class="col-9">
                                                                            <input class="form-control" name="percent"
                                                                                type="number" min=1 placeholder="Percent"
                                                                                value="{{ old('percent', isset($ss_tax->percent) ? $ss_tax->percent : '') }}"
                                                                                required />
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong class="error-percent"></strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-success">Update</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="{{ route('income-tax.edit', $income_taxe->id) }}"
                                                data-id="{{ $income_taxe->id }}"
                                                style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm">Change</a>
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
    <div class="container-fluid">

    @endsection
    @section('modals')
        <div class="modal fade" id="modal-change-holiday" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="changeHolidayLabel" aria-hidden="true">

        </div>
    @endsection

    @section('css')
        <style type="text/css">
            .required:after {
                content: " *";
                color: red;
            }

        </style>
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
