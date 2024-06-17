@extends('layouts.guest')
@section('title', 'Welcome')
@section('content')
    <div class="loginWrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="loginBg">
                        <div class="userIconLog">
                            <img src="{{ asset('theme/images/logo-small.png') }}" alt="">
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="  row">
                                <div class="col-lg-12 mb-3">
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                    <input type="email" class="form-control custom-form-control" name="email"
                                        aria-describedby="emailHelp" placeholder="Enter email" required>
                                    <span id="emailHelp" class="form-text text-danger">
                                        @error('email')
                                            <small>
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input type="password" class="form-control custom-form-control" name="password"
                                        placeholder="Password">

                                </div>


                                <div class="col-lg-12 mb-3 mt-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="rememberpass"
                                            name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="rememberpass"> Remember Me</label>
                                    </div>


                                </div>
                                <div class="col-lg-12">
                                    <button type="submit"
                                        style="--main_header_color : {{ $settings->main_header_color }};"
                                        class="btn btn-primary w-100">
                                        Log In
                                        <i data-feather="log-in" class="me-2"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-end mt-3">
                                <small>
                                    <a href="{{ route('password.request') }}"
                                        class="text-primary font-weight-normal">Forgot Password</a>
                                </small>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="poweredByLogo"><img src="{{ asset('theme/images/pocketLogo.png') }}" alt=""></div>
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
