@extends('layouts.layout')
@section('title', 'Send Report')

@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5>Create Report</h5>
                            <button style="--main_header_color : {{ $settings->main_header_color }};"
                                    class="btn btn-secondary btn-sm btn-add-report"><i data-feather="plus"></i>Add
                                Report
                            </button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="projects_list" value="{{ json_encode($projects->except('id')->toArray()) }}">

                <div class="col-lg-12 mt-2">
                    <div class="newHrFormGrp bg-lgrey">
                        <form action="{{ route('report.store') }}" method="POST" autocomplete="off" class="report-form"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="field_wrapper">
                                <div class="report border-0 p-0 m-0" data-id=0>
                                    <div class="row">
                                        <div class="col-lg-12 form-group">
                                            <span class="other-alert col-lg-12 col-md-12 col-sm-12 col-xs-12 m-0 p-0 ">
                                                <div class="alert alert-info m-0"><strong>
                                                        “Others” option is for
                                                        something like meeting, brainstorming, or had to go out to meet some
                                                        clients etc.
                                                    </strong>
                                                </div>
                                            </span>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label for="reportDate">Date <span class="text-danger">*</span></label>

                                            <div class="input-group">
                                                <input type="text" name="report[0][date]"
                                                       class="single-date reportDate form-control" required="">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label for="title">Title <span class="text-danger">*</span></label>
                                            <select name="report[0][project]" class="title form-control dropdown"
                                                    required="">
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}"
                                                            data-is-other="{{ $project->is_other }}"
                                                            class="form-control">
                                                        {{ $project->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label for="title">Optional Title</label>
                                            <input type="text" name="report[0][title]" class="form-control opt_title"
                                                   placeholder="Optional Title">
                                        </div>

                                        <div class="col-lg-6 form-group">
                                            <label for="title">Time
                                                Spent</label>
                                                <div class="d-flex align-items-center">
                                                    <input type="number" name="report[0][hr_time]" step="0.1" class="form-control mr-2"
                                                           placeholder="Hours Spent" min="0" max="24" required>
                                                        <label for="">Hour</label>
                                                        <input type="number" name="report[0][time]" step="0.1" class="form-control ml-2 mr-2"
                                                           placeholder="Time" min="0" required>
                                                        <label for="">Minutes</label>
                                                    </div>
                                        </div>
                                        <div class="col-lg-6  form-group">
                                            <label for="description">Description <span class="text-danger">*</span></label>
                                            <textarea rows="10" name="report[0][description]" class="form-control"
                                                      required></textarea>
                                        </div>

                                        <div class="col-lg-6  form-group">
                                            <label for="remark">Remarks</label>
                                            <textarea rows="10" name="report[0][remark]"
                                                      class="form-control"></textarea>
                                        </div>

                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                            <label for="remark">File</label>

                                            <input type="file" name="report[0][file]" class="form-control"
                                                   accept=".txt,.pdf,.xls,.docx,.jpeg,.jpg">
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="submit"
                                            style="--main_header_color : {{ $settings->main_header_color }};"
                                            class="btn btn-primary"><i data-feather="send"></i>Submit Now
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('js')

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        var report_count = 1;
        const other_alert =
            '<div class="alert bg-warning alert-info text-light font-weight-normal">“Others” option is for something like meeting, brainstorming, or had to go out to meet some clients etc. </div> '
        $('.single-date').daterangepicker({
            "singleDatePicker": true,
            "maxDate": moment()
        }, function (start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        $(document).on('click', '.btn-add-report', function () {
            var report = createReport()
            $('.field_wrapper').append(report)
            $('.single-date').daterangepicker({
                "singleDatePicker": true,
                "maxDate": moment()
            })

        })

        function createReport() {
            var projects = JSON.parse($('input[name="projects_list"]').val())

            var content = ''
            content += '<div class="report" data-id="' + report_count + '">' +

                '<span class="other-alert col-lg-12 col-md-12 col-sm-12 col-xs-12 ">' +

                '<div class="alert bg-warning alert-info text-light">' +
                '“Others” option is for something like meeting, brainstorming, or had to go out to meet some clients etc.' +
                '</div>' +
                '</span>' +
                '<div class="row">' +
                '<div class="col-lg-6 form-group">' +
                '<label for="reportDate">Date</label>' +
                '<div class="input-group">' +
                '<input type="text" name="report[' + report_count +
                '][date]" class="single-date reportDate form-control" required="">' +
                '<div class="input-group-prepend">' +
                '<div class="input-group-text"><i class="fa fa-calendar"></i>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-6 form-group">' +
                '<label for="title">Title</label>' +
                '<select name="report[' + report_count + '][project]" class="title form-control dropdown" required="">'
            $.each(projects, function (key, value) {
                content += '<option value="' + value.id + '" data-is-other="' + value.is_other +
                    '"  class="form-control">' + value.name + '</option>'
            });
            content += '</select>' +
                '</div>' +
                '<div class="col-lg-6 form-group">' +
                '<div class="optional-title-here">' +
                '<label for="title">Optional Title</label>' +
                '<input type="text" name="report[' + report_count +
                '][title]" class="form-control" placeholder="Optional Title">' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-6 form-group">' +
                '<label for="title">Time Spent</label>' +
                '<div class="d-flex align-items-center">'+
                '<input type="number" name="report[' + report_count +'][hr_time]" step="0.1" class="form-control mr-2" placeholder="Hours Spent" min="0" max="24" required>'+
                '<label for="">Hour</label>'+
                '<input type="number" name="report[' + report_count + '][time]" step="0.1" class="form-control ml-2 mr-2" placeholder="Time" min="0" required>'+
                '<label for="">Minutes</label>'+
                '</div>'+
                '</div>' +
                '<div class="col-md-6 form-group">' +
                '<label for="description">Description</label>' +
                '<textarea rows="10" name="report[' + report_count +
                '][description]" class="form-control" required></textarea>' +
                '</div>' +

                '<div class="col-md-6 form-group">' +
                '<label for="remark">Remarks</label>' +
                '<textarea rows="10" name="report[' + report_count + '][remark]" class="form-control"></textarea>' +
                '</div>' +
                '<div class="col-md-6">' +
                '<label for="File">Time Spent</label>' +
                '<input type="file" class="form-control" name="report[' + report_count + '][file]" ' +
                'accept=".txt,.pdf,.xls,.docx,.jpeg,.jpg">' +
                '</div>' +
                '</div> ' +
                '</div> ' +
                '</div>'
            report_count++
            return content;
        }

        $(document).on('change', '.title', function () {
            var val = $(this).val()
            var is_other = $(this).find(':selected').data('is-other')
            var __this = $(this)
            var __report = __this.closest('.report')
            var id = __report.data('id')
            if (is_other) {
                __report.find('.other-alert').html(other_alert)
                __report.find('.optional-title-here').html(createOptionalTitle(id))


            } else {
                __report.find('.other-alert').html('')
                __report.find('.optional-title-here').html('')


            }
        })

        function createOptionalTitle(count) {
            var content = '<div class="row form-group">' +
                '<div class="col">' +

                '<input type="text" name="report[' + count +
                '][title]" class="form-control" placeholder="Optional Title" required>' +
                '</div>' +
                '</div>'
            return content
        }
    </script>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <style>
        .report {
            padding-bottom: 1rem;
            /*padding-top:1rem;*/
            /*border-bottom:1px solid black;*/
            border-bottom: 1px solid rgba(0, 0, 0, .1);
            margin-bottom: 1rem;
        }

    </style>
@endsection
