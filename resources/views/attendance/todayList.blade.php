@extends('layouts.guest')
@section('title', 'Welcome')
@section('content')
    <div class="loginInfo">
        <div class="largeScreen">
            <div class="loginInner">
                <div class="loginInfoData">
                    <div class="loginTableBg">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                            <h5>Today's Attendance List</h5>
                            <div class='searchBox' style="--main_header_color : {{ $settings->main_header_color }};">
                                <form class='search-form'>
                                    <input class="form-control quicksearch" placeholder="Search" type='text'>
                                    <button class='btn btn-link search-btn btn-sm'>
                                        <i data-feather='search'></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="loginListTableGrp">
                            <div class="table-responsive"
                                 style="--main_header_color : {{ $settings->main_header_color }};">
                                <table class="table table-hover table-borderless attendance-table text-left mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="attendance-user-list">
                                    @foreach ($attendance_user as $user)
                                        @if ($user['type'] == 'clockout')
                                            <tr>
                                                <td class="d-flex align-items-center">
                                                    @includeIf('common.userImage_withoutLogin')
                                                    <span class="name">{{ $user['user']->name }}</span>
                                                </td>
                                                <td>{{ $user['user']->department->name }}</td>
                                                <td>
                                                    @if (empty($user['attendance']->is_absent))
                                                        <span class="bgSuccess">
                                                    Clocked in
                                                {{ Carbon\Carbon::parse($user['attendance']->clockin)->format('g:i A')  }}
                                                </span>

                                                    @else
                                                        <span
                                                            class="text-danger">{{ $user['attendance']->remarks }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (empty($user['attendance']->is_absent))
                                                        <span>
     <button
         class="btn btn-danger btn-sm btn-clockout-red attendance-btn btn-clockout"
         data-user-id="{{ $user['user']->id }}">
     <i data-feather="log-out"></i> Clock out
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

                                            </tr>
                                        @elseif($user['type'] == 'clockin')
                                            <tr>
                                                <td class="d-flex align-items-center">
                                                    @includeIf('common.userImage_withoutLogin')
                                                    <span class="name">{{ $user['user']->name }}</span>
                                                </td>
                                                <td>
                                                    {{ $user['user']->department->name }}
                                                </td>
                                                <td class="not-clocked">
                                                    @if (!$user['leave'])
                                                        <span class="bgDanger">
                                                Not clocked in yet

                                                </span>
                                                    @else
                                                        On Leave
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!$user['leave'])
                                                        <span>
     <button
         class="btn btn-danger btn-sm attendance-btn btn-clockin-green btn-clockin"
         data-user-id="{{ $user['user']->id }}">
              <i data-feather="log-in"></i>
     Clock In
     </button>
     </span>
                                                    @else
                                                        @if ($user['leave_type'] == 'half' && $user['allow_attendance'])
                                                            <span>
     <button
         class="btn btn-danger btn-sm attendance-btn btn-clockin-green btn-clockin"
         data-user-id="{{ $user['user']->id }}">
         <i data-feather="log-in"></i>
     Clock In
     </button>
     </span>
                                                        @endif
                                                    @endif

                                                </td>

                                            </tr>
                                        @elseif($user['type'] == 'default-clockout')
                                            <tr>
                                                <td class="d-flex align-items-center">
                                                    @includeIf('common.userImage_withoutLogin')

                                                    <span class="name">{{ $user['user']->name }}</span>

                                                </td>
                                                <td>
                                                    {{ $user['user']->department->name }}
                                                </td>
                                                <td class="not-clocked">You are yet to clockout</td>
                                                <td>
                                                        <span><button
                                                                class="btn btn-danger btn-sm attendance-btn btn-clockin-green"
                                                                disabled> <i data-feather="log-in"></i>Clockin</button></span>
                                                </td>
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
        <div class="smallScreen">
            <div class="smallAttendanceList" style="--main_header_color : {{ $settings->main_header_color }};">
                <h5>Today's Attendance List</h5>
                <div class="row">
                    @foreach ($attendance_user as $user)
                        <div class="col-lg-12 col-md-6 col-sm-6 col-12">
                            @if ($user['type'] == 'clockout')
                                <div class="loginTableBg smalllAttendList">
                                    <div class="d-flex align-items-center">
                                        <div class="attendanceImg">
                                            @if($user['user']->profile_image)
                                                <img src="{{ asset('uploads/UserDocuments/thumbnail/'.$user['user']->profile_image) }}">
                                            @else
                                                <img src="{{ asset('theme/images/user.png') }}">
                                            @endif
                                        </div>
                                        <div class="attendanceInfo">
                                            <h6>{{ $user['user']->name }}</h6>
                                            <p>
                                                {{ $user['user']->department->name }}
                                            </p>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="notClocked">
                                            @if (empty($user['attendance']->is_absent))
                                                <p class="text-success"><em>Clocked
                                                        In {{ Carbon\Carbon::parse($user['attendance']->clockin)->format('g:i A')  }} </em>
                                                </p>

                                            @else
                                                <p class="text-danger"><em>{{ $user['attendance']->remarks }}</em></p>
                                            @endif

                                        </div>
                                        @if (empty($user['attendance']->is_absent))
                                            <button
                                                class="btn btn-danger btn-sm w-auto btn-clockout-red attendance-btn btn-clockout"
                                                data-user-id="{{ $user['user']->id }}">
                                                <i data-feather="log-out"></i>
                                                Clock Out
                                            </button>
                                        @else
                                            <button class="btn btn-danger btn-sm btn-clockout-red attendance-btn"
                                                    style="cursor: not-allowed;" disabled
                                            >
                                                Absent
                                            </button>
                                        @endif
                                    </div>

                                </div>
                            @elseif($user['type'] == 'clockin')
                                <div class="loginTableBg smalllAttendList">
                                    <div class="d-flex align-items-center">
                                        <div class="attendanceImg">
                                            @if($user['user']->profile_image)
                                                <img src="{{ asset('uploads/UserDocuments/thumbnail/'.$user['user']->profile_image) }}">
                                            @else
                                                <img src="{{ asset('theme/images/user.png') }}">
                                            @endif
                                        </div>
                                        <div class="attendanceInfo">
                                            <h6>{{ $user['user']->name }}</h6>
                                            <p>
                                                {{ $user['user']->department->name }}
                                            </p>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="notClocked">
                                            @if (!$user['leave'])
                                                <p class="text-danger"><em>Not Clocked Yet</em></p>
                                            @else
                                                <p class="text-danger"><em>On Leave</em></p>
                                            @endif
                                        </div>
                                        @if (!$user['leave'])
                                            <button
                                                class="btn btn-danger btn-sm attendance-btn btn-clockin-green btn-clockin"
                                                data-user-id="{{ $user['user']->id }}">
                                                <i data-feather="log-in"></i>
                                                Clock In
                                            </button>
                                        @else
                                            @if ($user['leave_type'] == 'half' && $user['allow_attendance'])
                                                <button
                                                    class="btn btn-danger btn-sm attendance-btn btn-clockin-green btn-clockin"
                                                    data-user-id="{{ $user['user']->id }}">
                                                    <i data-feather="log-in"></i>
                                                    Clock In
                                                </button>
                                            @endif
                                        @endif
                                    </div>

                                </div>
                            @elseif($user['type'] == 'default-clockout')
                                <div class="loginTableBg smalllAttendList">
                                    <div class="d-flex align-items-center">
                                        <div class="attendanceImg">
                                            @if($user['user']->profile_image)
                                                <img src="{{ asset('uploads/UserDocuments/thumbnail/'.$user['user']->profile_image) }}">
                                            @else
                                                <img src="{{ asset('theme/images/user.png') }}">
                                            @endif
                                        </div>
                                        <div class="attendanceInfo">
                                            <h6>{{ $user['user']->name }}</h6>
                                            <p>
                                                {{ $user['user']->department->name }}
                                            </p>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="notClocked">
                                            @if (!$user['leave'])
                                                <p class="text-danger"><em>Not Clocked Yet</em></p>

                                            @else
                                                <p class="text-danger"><em>Not Clocked Yet</em></p>
                                            @endif
                                        </div>
                                        <button
                                            class="btn btn-danger btn-sm attendance-btn btn-clockin-green"
                                            disabled><i data-feather="log-in"></i>Clock In
                                        </button>
                                    </div>

                                </div>
                            @endif
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    </div>


@endsection
@section('css')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link href="{{ asset('assets/plugin/core/main.css') }}" rel='stylesheet'/>
    <link href="{{ asset('assets/plugin/daygrid/main.css') }}" rel='stylesheet'/>
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
            filter: function () {
                return qsRegex ? $(this).text().match(qsRegex) : true;
            }
        });

        // use value of search field to filter
        var $quicksearch = $('.quicksearch').keyup(debounce(function () {
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
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $('input[name="start"]').daterangepicker({
            "singleDatePicker": true,
            "minDate": moment(),
        }, function (start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        $('input[name="end"]').daterangepicker({
            "singleDatePicker": true,
            "minDate": moment(),
        }, function (start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
    </script>
    <script src="{{ asset('assets/plugin/core/main.js') }}"></script>
    <script src="{{ asset('assets/plugin/interaction/main.js') }}"></script>
    <script src="{{ asset('assets/plugin/daygrid/main.js') }}"></script>
    <script>
        $(document).on('click', '.btn-check-email', function (e) {
            var email = $('#form-create-leave').find('input[name="email"]').val();
            $.ajax({
                url: check_user_url,
                method: "POST",
                data: {
                    email: email
                },
                beforeSend: function (xhr) {
                }
            })
                .done(function (data) {
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

        $('#create-leave-modal').on('hidden.bs.modal', function (e) {
            $("input:radio[name='leave_type']").each(function (i) {
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
    <div class="modal fade" id="guest-modal-clockin" data-backdrop="static" tabindex="-1"
         role="dialog"
         aria-labelledby="clockinLabel" aria-hidden="true"></div>
    <div class="modal fade" id="guest-modal-clockout" data-backdrop="static" tabindex="-1"
         role="dialog"
         aria-labelledby="clockoutLabel" aria-hidden="true"></div>
@endsection
