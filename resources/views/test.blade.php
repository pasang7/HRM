@extends('layouts.guest')
@section('title', 'Welcome')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="attendance-wrapper">
                    <div class="row">
                        <div class="col-lg-8 col-md-7 col-sm-6 col-xs-12">
                            <p class="attendance-title">Employee Lists</p>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class='search-box'>
                                <form class='search-form'>
                                    <input class="form-control quicksearch" placeholder="Search" type='text'>
                                    <button class='btn btn-link search-btn btn-sm'>
                                        <i class='fa fa-search'></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card attendance-card margin-top-1">
                                <div class="card-body">
                                    <div>
                                        <table class="table table-borderless attendance-table mb-0">
                                            <thead class="header-bg"
                                                style="--sec_header_color: {{ $settings->sec_header_color }};">
                                                <tr>
                                                    <th scope="col"></th>
                                                    <th scope="col" class="text-left">Name</th>
                                                    <th scope="col">Action</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="attendance-user-list">
                                                @foreach ($attendance_user as $user)
                                                    @if ($user['type'] == 'clockout')
                                                        <tr class="element-item">
                                                            <td>
                                                                @includeIf('common.userImage_withoutLogin')
                                                            </td>
                                                            <td class="text-left">
                                                                <span
                                                                    class="name">{{ $user['user']->name }}</span>
                                                                <span
                                                                    class="color-g2">{{ $user['user']->department->name }}</span>
                                                            </td>
                                                            <td>
                                                                @if (empty($user['attendance']->is_absent))
                                                                    <span>
                                                                        <button
                                                                            class="btn btn-danger btn-sm btn-clockout-red attendance-btn btn-clockout"
                                                                            data-user-id="{{ $user['user']->id }}">
                                                                            <i class="fa fa-sign-out"></i> Clockout
                                                                        </button>
                                                                    </span>
                                                                @else
                                                                    <span>
                                                                        <button
                                                                            class="btn btn-danger btn-sm btn-clockout-red attendance-btn"
                                                                            style="cursor: not-allowed;" disabled> Absent
                                                                        </button>
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if (empty($user['attendance']->is_absent))
                                                                    Clocked in
                                                                    {{ Carbon\Carbon::parse($user['attendance']->clockin)->diffForHumans() }}
                                                                @else
                                                                    <span
                                                                        class="text-danger">{{ $user['attendance']->remarks }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @elseif($user['type'] == 'clockin')
                                                        <tr class="element-item">
                                                            <td>
                                                                @includeIf('common.userImage_withoutLogin')
                                                            </td>
                                                            <td class="text-left">
                                                                <span
                                                                    class="name">{{ $user['user']->name }}</span>
                                                                <span
                                                                    class="color-g2">{{ $user['user']->department->name }}</span>
                                                            </td>
                                                            <td>
                                                                @if (!$user['leave'])
                                                                    <span>
                                                                        <button
                                                                            class="btn btn-danger btn-sm attendance-btn btn-clockin-green btn-clockin"
                                                                            data-user-id="{{ $user['user']->id }}">
                                                                            <i class="fa fa-sign-in"></i>clockin
                                                                        </button>
                                                                    </span>
                                                                @else
                                                                    @if ($user['leave_type'] == 'half' && $user['allow_attendance'])
                                                                        <span>
                                                                            <button
                                                                                class="btn btn-danger btn-sm attendance-btn btn-clockin-green btn-clockin"
                                                                                data-user-id="{{ $user['user']->id }}">
                                                                                <i class="fa fa-sign-in"></i>clockin
                                                                            </button>
                                                                        </span>
                                                                    @endif
                                                                @endif

                                                            </td>
                                                            <td class="not-clocked">
                                                                @if (!$user['leave'])
                                                                    Not clocked in yet
                                                                @else
                                                                    On Leave
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @elseif($user['type'] == 'default-clockout')
                                                        <tr class="element-item">
                                                            <td>
                                                                @includeIf('common.userImage_withoutLogin')
                                                            </td>
                                                            <td class="text-left">
                                                                <span
                                                                    class="name">{{ $user['user']->name }}</span>
                                                                <span
                                                                    class="color-g2">{{ $user['user']->department->name }}</span>
                                                            </td>
                                                            <td>
                                                                <span><button
                                                                        class="btn btn-danger btn-sm attendance-btn btn-clockin-green"
                                                                        disabled> <i class="fa fa-sign-in"></i>
                                                                        Clockin</button></span>
                                                            </td>
                                                            <td class="not-clocked">You are yet to clockout</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="{{ asset('assets/plugin/core/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('assets/plugin/daygrid/main.css') }}" rel='stylesheet' />
    <style>
        .element-item {
            position: relative !important;
        }

    </style>
@endsection
@section('js')
    <script src="{{ asset('js/common.js') }}"></script>
    <script>
        const get_clockin_form = "{{ route('guest.get-change-clockin-form') }}"
        const get_clockout_form = "{{ route('guest.get-change-clockout-form') }}"
        const get_default_clockout_form = "{{ route('guest.get-default-clockout-form') }}"
        var get_event_url = "{{ route('company-calendar.get-month-event') }}";
        var get_leave_form = "{{ route('leave.get.form.guest') }}";
        var check_user_url = "{{ route('leave.check.user') }}";
    </script>
    <script>
        //Quick search
        // quick search regex
        var qsRegex;

        // init Isotope
        var $grid = $('#attendance-user-list').isotope({
            itemSelector: '.element-item',
            layoutMode: 'fitRows',
            filter: function() {
                return qsRegex ? $(this).text().match(qsRegex) : true;
            }
        });

        // use value of search field to filter
        var $quicksearch = $('.quicksearch').keyup(debounce(function() {
            qsRegex = new RegExp($quicksearch.val(), 'gi');
            $grid.isotope();
        }, 200));

        // debounce so filtering doesn't happen every millisecond
        function debounce(fn, threshold) {
            var timeout;
            threshold = threshold || 100;
            return function debounced() {
                clearTimeout(timeout);
                var args = arguments;
                var _this = this;

                function delayed() {
                    fn.apply(_this, args);
                }
                timeout = setTimeout(delayed, threshold);
            };
        }
    </script>
    <script src="{{ asset('js/guest_attendance.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $('input[name="start"]').daterangepicker({
            "singleDatePicker": true,
            "minDate": moment(),
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        $('input[name="end"]').daterangepicker({
            "singleDatePicker": true,
            "minDate": moment(),
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
    </script>
    <script src="{{ asset('assets/plugin/core/main.js') }}"></script>
    <script src="{{ asset('assets/plugin/interaction/main.js') }}"></script>
    <script src="{{ asset('assets/plugin/daygrid/main.js') }}"></script>
    <script>
        $(document).on('click', '.btn-check-email', function(e) {
            var email = $('#form-create-leave').find('input[name="email"]').val();
            $.ajax({
                    url: check_user_url,
                    method: "POST",
                    data: {
                        email: email
                    },
                    beforeSend: function(xhr) {}
                })
                .done(function(data) {
                    var res = JSON.parse(data)
                    if (res.status) {
                        $('.form-part-2').html(res.view)
                        if (res.redirect)
                            window.location.href = res.redirect_url;
                    } else {
                        showAlert('error', res.title, res.text)
                    }
                });
        })

        function makeid(length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

        $('#create-leave-modal').on('hidden.bs.modal', function(e) {
            $("input:radio[name='leave_type']").each(function(i) {
                if (i == 0) {
                    this.checked = true;
                } else {
                    this.checked = false;
                }
            });
            $(this).find('.day-breakdown').html('')
        })
    </script>
@endsection
@section('modals')
    <div class="modal fade" id="guest-modal-clockin" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="clockinLabel" aria-hidden="true"></div>
    <div class="modal fade" id="guest-modal-clockout" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="clockoutLabel" aria-hidden="true"></div>
@endsection
