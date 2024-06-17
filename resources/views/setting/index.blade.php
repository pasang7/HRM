@extends('layouts.layout')
@section('title', 'Settings')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-4">

                <div class="card">

                    <div class="card-body bg-lgrey">
                        <div class="hrprosubHead">
                            <h5>
                                Change Master PIN
                            </h5>
                        </div>
                        <div class="custom-form-wrapper">
                            <form autocomplete="off" method="POST" action="{{ route('setting.change-master-pin') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="pin">New Pin</label>
                                    <input type="number" name="pin" min=1000 max="9999"
                                        class="form-control custom-form-control" placeholder="New Pin"
                                        value="{{ old('pin') }}" required>
                                    @error('pin')
                                        <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="submit" class="btn btn-sm btn-primary"><i data-feather="check"></i>Update
                                        Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">

                    <div class="card-body bg-lgrey">
                        <div class="hrprosubHead">
                            <h5>
                                Company Setting
                            </h5>
                        </div>
                        <div class="custom-form-wrapper">
                            <form autocomplete="off" method="POST" action="{{ route('setting.change-company-details') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Company Name</label>
                                    <input type="text" name="name" class="form-control custom-form-control"
                                        placeholder="Company Name" value="{{ old('name') ? old('name') : $company_name }}"
                                        required>
                                    @error('name')
                                        <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="submit" class="btn btn-sm btn-primary"><i data-feather="check"></i>Update
                                        Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">

                    <div class="card-body bg-lgrey">
                        <div class="hrprosubHead">
                            <h5>
                                Fiscal Year
                            </h5>
                        </div>
                        <div class="custom-form-wrapper">
                            <form autocomplete="off" method="POST"
                                action="{{ route('setting.change-company-fiscal-year') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Fiscal Year (Start)</label>
                                    <input type="text" name="fiscal_year" class="form-control custom-form-control"
                                        placeholder="Date" value="{{ $fiscal_year }}" required>
                                    @error('fiscal_year')
                                        <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="submit" class="btn btn-sm btn-primary"><i data-feather="check"></i>Update
                                        Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-md-6">
                <div class="card">
                    <div class="card-header header-bg" style="--sec_header_color: {{ $settings->sec_header_color }};">
                        <p class="mb-0 fw-600">Finance Setup</p>
                    </div>

                    <div class="card-body bg-lgrey">
                        <div class="custom-form-wrapper">
                            <form autocomplete="off" method="POST" action="{{ route('setting.change-company-fiscal-year') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Fiscal Year</label>
                                    <input type="text" name="fiscal_year" class="form-control custom-form-control"
                                        placeholder="Date" value="{{$fiscal_year}}" required>
                                    @error('fiscal_year')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header header-bg" style="--sec_header_color: {{ $settings->sec_header_color }};">
                        <p class="mb-0 fw-600">Finance Setup</p>
                    </div>

                    <div class="card-body bg-lgrey">
                        <div class="custom-form-wrapper">
                            <form autocomplete="off" method="POST" action="{{ route('setting.change-company-fiscal-year') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Fiscal Year</label>
                                    <input type="text" name="fiscal_year" class="form-control custom-form-control"
                                        placeholder="Date" value="{{$fiscal_year}}" required>
                                    @error('fiscal_year')
                                    <small class="form-text text-muted">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="companySetup-tab" data-toggle="tab" href="#companySetup" role="tab" aria-controls="companySetup" aria-selected="true">Company Settings</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="financeSetup-tab" data-toggle="tab" href="#financeSetup" role="tab" aria-controls="financeSetup" aria-selected="false">Finance Setting</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="companySetup" role="tabpanel" aria-labelledby="companySetup-tab">
                        <div class="container-fluid">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="custom-form-wrapper">
                                            <form autocomplete="off" method="POST" action="{{ route('setting.change-master-pin') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="pin">New Pin</label>
                                                    <input type="number" name="pin" min=1000 max="9999"
                                                        class="form-control custom-form-control" placeholder="New Pin"
                                                        value="{{ old('pin') }}" required>
                                                    @error('pin')
                                                    <small class="form-text text-muted">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-primary">Update Pin</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="financeSetup" role="tabpanel" aria-labelledby="financeSetup-tab">...</div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                  </div>
            </div> --}}
        </div>
    </div>
@endsection

@section('js')

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        function toggleX(x) {
            checkbox = document.getElementById('checkall');
            checkbox.checked = false;
        }

        function toggle(source) {
            checkboxes = document.getElementsByName('permission[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
        $('input[name="fiscal_year"]').daterangepicker({
            "singleDatePicker": true,
            // "startDate": "11/29/2019",
            // "endDate": "12/05/2019",
            locale: {
                format: 'M/DD'
            }
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
    </script>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
