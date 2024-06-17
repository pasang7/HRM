<!DOCTYPE html>
<html>

<head>
    @php
        $version = rand();
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HR PRO') }} | @yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/Setting/thumbnail/' . $settings->logo) }}">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="{{ asset('theme/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/font-awesome.min.css') }}">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('theme/css/datatables.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/modal.css') }}">
    @toastr_css
    @yield('css')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
    <!-- Datatable -->
    <!-- <link rel="stylesheet" href="{{ asset('theme/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/datatables.min.css') }}"> -->

    <!-- Datatable -->
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: #fff !important;
        }

        .hrproloaderBg {
            background-color: rgba(255, 255, 255, 0.95);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000000;
            opacity: 1;
        }

        .lds-roller {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 90vh;
            width: 90%;
        }

        .lds-roller div {
            animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            transform-origin: 40px 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lds-roller div:after {
            content: " ";
            display: block;
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--main_header_color);
            margin: -4px 0 0 -4px;
        }

        .lds-roller div:nth-child(1) {
            animation-delay: -0.036s;
        }

        .lds-roller div:nth-child(1):after {
            top: 63px;
            left: 63px;
        }

        .lds-roller div:nth-child(2) {
            animation-delay: -0.072s;
        }

        .lds-roller div:nth-child(2):after {
            top: 68px;
            left: 56px;
        }

        .lds-roller div:nth-child(3) {
            animation-delay: -0.108s;
        }

        .lds-roller div:nth-child(3):after {
            top: 71px;
            left: 48px;
        }

        .lds-roller div:nth-child(4) {
            animation-delay: -0.144s;
        }

        .lds-roller div:nth-child(4):after {
            top: 72px;
            left: 40px;
        }

        .lds-roller div:nth-child(5) {
            animation-delay: -0.18s;
        }

        .lds-roller div:nth-child(5):after {
            top: 71px;
            left: 32px;
        }

        .lds-roller div:nth-child(6) {
            animation-delay: -0.216s;
        }

        .lds-roller div:nth-child(6):after {
            top: 68px;
            left: 24px;
        }

        .lds-roller div:nth-child(7) {
            animation-delay: -0.252s;
        }

        .lds-roller div:nth-child(7):after {
            top: 63px;
            left: 17px;
        }

        .lds-roller div:nth-child(8) {
            animation-delay: -0.288s;
        }

        .lds-roller div:nth-child(8):after {
            top: 56px;
            left: 12px;
        }

        @keyframes lds-roller {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

    </style>
    <link href="{{ asset('css/chung-timepicker.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('theme/css/style.css?v=' . $version) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/responsive.css?v=' . $version) }}">
</head>

<body>
    @include('layouts.component.side-nav')

    {{-- <div>
        <a class="top-link show" href="{{ route('locked') }}" id="js-top">
            <span class="screen-reader-text"><i class="fa fa-long-arrow-left"></i></span>
        </a>
    </div> --}}
    <div class="main-content">
        @include('layouts.component.top-nav')
        @yield('content')
        <div class="hrproloaderBg" id="hrproloader"
            style="--main_header_color : {{ $settings->main_header_color }};">
            <div class="lds-roller">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="col-md-12 text-right">
            <div class="copyrightFooter">
                <a href="https://pocketstudionepal.com/" target="_blank">
                    Powered By: Pocket Studio
                </a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-clockin" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="clockinLabel" aria-hidden="true">
    </div>
    <div class="modal fade" id="modal-clockout" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="clockoutLabel" aria-hidden="true">
    </div>
    <img id='image-handler' src='{{ asset('theme/images/loading.gif') }}' alt='url preview'
        style="display:none; z-index:9999;position: fixed; top: 80%;left: 15%; transform: translate(-50%,-50%);">
    @yield('modals')
    <script src="{{ asset('theme/js/jquery-3.js') }}"></script>
    <script src="{{ asset('theme/js/popper.min.js') }}"></script>
    <script src="{{ asset('theme/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/js/moment.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-clock-timepicker.min.js') }}"></script>


    <!-- Datatable -->
    <!-- <script src="{{ asset('theme/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/js/dataTables.buttons.min.js') }}"></script> -->
    <script src="{{ asset('theme/js/jszip.min.js') }}"></script>
    <script src="{{ asset('theme/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('theme/js/vfs_fonts.js') }}"></script>
    {{-- <script src="{{ asset('theme/js/buttons.html5.min.js') }}"></script> --}}
    <script src="{{ asset('theme/js/datatables.min.js') }}"></script>
    <script src="{{ asset('theme/js/feather.min.js') }}"></script>
    <!-- Datatable -->
    <script src="{{ asset('js/flatpickr.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#hrproloader').hide();
            }, 150);
        })
        feather.replace()
        flatpickr("#dob", {
            enableTime: false,
            dateFormat: "m/d/Y",
            defaultDate: "today",
        });
        flatpickr(".datepick", {
            enableTime: false,
            dateFormat: "m/d/Y",
            defaultDate: "today",
            maxDate: "today"
        });
        flatpickr("#start_from", {
            enableTime: false,
            dateFormat: "m/d/Y",
            defaultDate: "today",
            minDate: "today"
        });
        flatpickr("#end_to", {
            enableTime: false,
            dateFormat: "m/d/Y",
            defaultDate: "today",
            minDate: "today"
        });
        flatpickr("#contract_start", {
            enableTime: false,
            dateFormat: "m/d/Y",
            maxDate: "today"
        });
        flatpickr("#contract_end", {
            enableTime: false,
            dateFormat: "m/d/Y",
            maxDate: "today"
        });
        // sidebar js
        document.addEventListener("DOMContentLoaded", () => {
            const nav = document.querySelector(".mobileMenuNav");
            document.querySelector("#btnNav").addEventListener("click", () => {
                nav.classList.add("mobileMenuOpen");
            });

            document.querySelector(".nav__overlay").addEventListener("click", () => {
                nav.classList.remove("mobileMenuOpen");
            });
        });
    </script>

    <script src="{{ asset('theme/js/all.js') }}"></script>
    <script src="{{ asset('theme/js/time-countdown.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('js')
    <script src="{{ asset('assets/plugin/webcam/webcam.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script>
        const get_clockin_form = "{{ route('attendance.get-change-clockin-form') }}"
        const get_clockout_form = "{{ route('attendance.get-change-clockout-form') }}"
        const get_default_clockout_form = "{{ route('attendance.get-default-clockout-form') }}"
    </script>
    <script src="{{ asset('js/attendance.js') }}"></script>
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
    <script>
        $(document).on("mouseover", ".image", function() {
            var name = $(this).data('image')
            $('#image-handler').attr('src', '/get-verification-image/' + name);
            $("#image-handler").show();
        });
        $(document).on("mouseout", ".image", function() {
            $("#image-handler").hide();
            $('#image-handler').attr('src', asset("theme/images/loading.gif"));
        });
    </script>

    @toastr_js
    @toastr_render

    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('js/chung-timepicker.js') }}"></script>


</body>

</html>
