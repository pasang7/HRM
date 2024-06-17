@extends('layouts.layout')
@section('title', 'Home')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="newHrBreadCumb">
                    <h5>Dashboard</h5>
                </div>
            </div>
            <!-- admin, ceo and hr view-->
            @if (Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3)
                @includeIf('dashboard.ceo')
            @endif

            <!-- DepartmentHead view -->
            @if (Auth::user()->role == 4 && Auth::user()->is_head == 'yes')
                @includeIf('dashboard.departmend_head')
            @endif
            <!-- DepartmentHead view end -->
            <!-- Staff view -->
            @if (Auth::user()->role == 5)
                @includeIf('dashboard.staff')
            @endif
            <!-- Staff view end -->
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $('.single-date').daterangepicker({
            "singleDatePicker": true,
            "minDate": moment()
        }, function(start, end, label) {});
    </script>
    <script>
        const mark_complete_url = "{{ route('task.mask-complete') }}";
        const remove_task_url = "{{ route('task.remove-task') }}";
        $(document).on('click', '.btn-mark-complete', function() {
            var task = $(this).closest('.task')
            var id = task.data('id')
            $.ajax({
                url: mark_complete_url,
                method: "POST",
                data: {
                    'id': id
                },
                success: function(data) {
                    location.reload()
                },
                error: function(data) {}
            });
        })

        $(document).on('click', '.btn-remove-task', function() {
            var task = $(this).closest('.task')
            var id = task.data('id')
            $.ajax({
                url: remove_task_url,
                method: "POST",
                data: {
                    'id': id
                },
                success: function(data) {
                    location.reload()

                },
                error: function(data) {


                }
            });
        })
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/echarts.min.js') }}"></script>
    {{-- Pie chart --}}
    <script type="text/javascript">
        var pie_basic_element = document.getElementById('pie_basic');
        if (pie_basic_element) {
            var pie_basic = echarts.init(pie_basic_element);
            pie_basic.setOption({
                color: [
                    '#2ec7c9', '#9071cf', '#f9dc85', '#f54646', '#d87a80',
                    '#8d98b3', '#e5cf0d', '#97b552', '#95706d', '#dc69aa',
                    '#07a2a4', '#9a7fd1', '#588dd5', '#f5994e', '#c05050',
                    '#59678c', '#c9ab00', '#7eb00a', '#6f5553', '#c14089'
                ],

                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                title: {
                    // text: 'Employee Analysis',
                    left: 'center',
                    textStyle: {
                        fontSize: 17,
                        fontWeight: 600
                    },
                    subtextStyle: {
                        fontSize: 12
                    }
                },

                tooltip: {
                    trigger: 'item',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    },
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },

                legend: {
                    orient: 'horizontal',
                    bottom: '0%',
                    left: 'center',
                    // data: ['Male', 'Female', 'Unmarried', 'Married'],
                    data: ['Male', 'Female'],
                    itemHeight: 8,
                    itemWidth: 8
                },

                series: [{
                    name: '',
                    type: 'pie',
                    radius: '70%',
                    center: ['50%', '50%'],
                    itemStyle: {
                        normal: {
                            borderWidth: 1,
                            borderColor: '#fff'
                        }
                    },
                    data: [{
                            value: {{ $pie_chart['male_count'] }},
                            name: 'Male'
                        },
                        {
                            value: {{ $pie_chart['female_count'] }},
                            name: 'Female'
                        },
                        // {
                        //     value: {{ $pie_chart['unmarried_count'] }},
                        //     name: 'Unmarried'
                        // },
                        // {
                        //     value: {{ $pie_chart['married_count'] }},
                        //     name: 'Married'
                        // },
                    ]
                }]
            });
        }
    </script>
    {{-- Bar --}}
    <script type="text/javascript">
        var bars_basic_element = document.getElementById('bars_basic');
        if (bars_basic_element) {
            var bars_basic = echarts.init(bars_basic_element);
            bars_basic.setOption({
                color: ['#3398DB'],
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: [{
                    type: 'value'
                }],
                yAxis: [{
                    type: 'category',
                    data: ['CEO', 'Line Manager', 'HR', 'Staff'],
                    axisTick: {
                        alignWithLabel: true
                    }
                }],
                series: [{
                    name: 'Employee No',
                    type: 'bar',
                    barWidth: '10%',
                    data: [
                        {{ $role['ceo'] }},
                        {{ $role['line_manager'] }},
                        {{ $role['hr'] }},
                        {{ $role['staff_count'] }}
                    ]
                }]
            });
        }
    </script>
    <!--Default chart-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $chart['chart']->script() !!}

    <!--Google Bar chart-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Employee Name', 'Salary'],
                @php
                foreach ($employees as $employee) {
                    echo "['" . $employee->name . "', " . $employee->current_salary->salary . '],';
                }
                @endphp
            ]);

            var options = {
                chart: {
                    title: 'Employee',
                },
                bars: 'vertical'
            };
            var chart = new google.charts.Bar(document.getElementById('barchart_material'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
@endsection
