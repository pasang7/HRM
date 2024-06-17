<!DOCTYPE html>
<html>

<head>
        @php
        $version = rand();
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HR PRO</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/theme/images/logo-small.png') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/font-awesome.min.css') }}">
    <link href="{{asset('css/font-awesome.min.css')}}">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('theme/css/style.css?v='. $version) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/welcome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/responsive.css?v='.$version) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/modal.css') }}">
     <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
           <link rel="stylesheet"
            href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
    @yield('css')
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
</head>

<body>
    <!-- <div class="clockin-header">
        <nav class="navbar navbar-inverse custom-navbar bg-blue navbar-fixed-top clockin-navbar" style="--main_header_color: {{ $settings->main_header_color }};">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{route('welcome')}}">
                        <img src="{{ asset('theme/images/logo-big.png') }}">
                    </a>
                </div>
                <div class="pull-right">
                    <div class="desktop-login">
                        <form class="header-form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <span>
                                <input type="email" class="form-control custom-form-control"
                                    name="email" required aria-describedby="emailHelp" placeholder="Enter email">
                                    <small id="emailHelp" class="form-text hidden-text">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </small>
                            </span>
                            <span>
                                <input type="password" class="form-control custom-form-control" name="password"
                                    placeholder="Password">
                                <a href="{{ route('password.request') }}" class="pull-right" >Forgot Password</a>
                            </span>
                            <span>
                                <button type="submit"
                                    style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-login bg-white margin-bottom-18 margin-right-0 btn-sm">login</button>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <section class="clockin-wrapper">
        <div class="mobile-login">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <form class="mobile-login-form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control custom-form-control" name="email"
                                    aria-describedby="emailHelp" placeholder="Enter email">
                                    <small id="emailHelp" class="form-text hidden-text">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </small>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control custom-form-control" name="password"
                                    placeholder="Password">
                                <a href="{{ route('password.request') }}" class="pull-right" id="forgot">Forgot Password</a>
                            </div>
                            <button type="submit"
                                style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-login bg-white margin-bottom-18 margin-right-0 btn-sm">login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <nav class="navbar navbar-expand-md fixed-top ">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <div class="navLogo">
                    @if($settings->logo)
                    <img src="{{ asset('uploads/Setting/thumbnail/' . $settings->logo) }}">
                    @else
                    <img src="{{asset('theme/images/logo.png')}}">
                    @endif
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i data-feather="menu"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('attendance.todayList') }}">Attendance</a>
                        </li>

                        <li class="nav-item">
                            <a style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary" href="{{ url('/') }}">Log In<i data-feather="log-in" class="ml-2"></i></a>
                        </li>
                </ul>
            </div>
        </div>
    </nav>
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
    @yield('modals')

    <script src="{{ asset('theme/js/jquery-3.js') }}"></script>
    <script src="{{ asset('theme/js/popper.min.js')}}">
    </script>

    <script src="{{ asset('theme/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/js/moment.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="{{ asset('assets/plugin/webcam/webcam.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('theme/js/feather.min.js') }}"></script>
    <script>
         $(document).ready(function() {
            setTimeout(function() {
                $('#hrproloader').hide();
            }, 150);
        })
        feather.replace()
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('js')

</body>

</html>
