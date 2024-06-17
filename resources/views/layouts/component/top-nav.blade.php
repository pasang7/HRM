@php
    $user = \App\Models\User::find(Auth::user()->id);
@endphp

<div class="mobile-view-header">
    <div class="smallScreen">
        <div class="mobileNavBar d-flex align-items-center justify-content-between"
             style="--main_header_color : {{ $settings->main_header_color }};">
            <div class="leftNavData d-flex align-items-center">
                <button id="btnNav" type="button">
                    <i data-feather="menu"></i>
                </button>
            </div>
            <div class="rightNavData d-flex align-items-center">
                <a title="Back" href="{{ URL::previous() }}" id="js-top" style="--main_header_color : {{ $settings->main_header_color }};">
                    <div class="backIcon">
                        <div class="backIconBg">
                            <i data-feather="arrow-left"></i>
                        </div>
                    </div>
                </a>
                @if ($attendance_status == 'show_clockin')
                    <button type="button" title="Clockin" class="btn btn-sm btn-success btn-clockin"
                            data-user-id="{{ Auth::user()->id }}"><i data-feather="log-in"></i>Clock In
                    </button>
                @elseif($attendance_status == 'show_clockout')
                    <button type="button" title="Clockout" class="btn btn-sm btn-danger btn-clockout"
                            data-user-id="{{ Auth::user()->id }}"><i data-feather="log-out"></i>Clock Out
                    </button>
                @elseif($attendance_status == 'show_default_clockout')
                    <button type="button" title="Old Clockout"
                            style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-default-clockout btn-clockin-white old-clockin "
                            data-user-id="{{ Auth::user()->id }}" data-id="{{ $old_default_clockout->id }}"><i
                            class="fa fa-clock-o"></i></button>
                @endif
                <div class="dropdown">
                    <a id="navbarDropdown" class="dropdown-toggle ps-0 pe-0 ms-2" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <div class="navUserImg">
                            @if (Auth::user()->profile_image)
                                <img src="{{ asset('uploads/UserDocuments/thumbnail/' . Auth::user()->profile_image) }}"
                                     alt="{{ Auth::user()->name }}'s picture" class="rounded-circle"/>
                            @else
                                <img src="{{ asset('theme/images/user.png') }}" class="rounded-circle">
                            @endif
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <div class="hrmDropMenuGrp">
                            <div class="d-flex align-items-center">
                                <div class="navUserImg ms-0">
                                    @if (Auth::user()->profile_image)
                                        <img
                                            src="{{ asset('uploads/UserDocuments/thumbnail/' . Auth::user()->profile_image) }}"
                                            alt="{{ Auth::user()->name }}'s picture" class="rounded-circle"/>
                                    @else
                                        <img src="{{ asset('theme/images/user.png') }}" class="rounded-circle">
                                    @endif
                                </div>
                                <div class="userinfoDrop">
                                    <p>{{Auth::User()->e_id}}</p>
                                    <h6>{{ Auth::user()->name }}</h6>
                                </div>
                            </div>
                            <hr class="drop-action-hr">
                            <a href="{{ route('profile.profile') }}" class="dropdown-item view-profile w-auto">
                                <i data-feather="eye"></i> My Profile</a>
                            <a href="{{ route('user.change.password') }}" class="dropdown-item change-pw">
                                <i data-feather="key"></i> Change Password</a>
                            <a href="{{ route('user.change.pin') }}" class="dropdown-item change-pin">
                                <i data-feather="lock"></i>Change
                                Pin</a>
                            <a href="{{ route('notification.all') }}" class="dropdown-item change-pin">
                                <i data-feather="bell"></i>Notifications
                                @if (count($user->unreadNotifications) > 0)
                                    <span class="badge badge-danger">{{ count($user->unreadNotifications) }}</span>
                                @endif
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    data-feather="log-out"></i> Logout</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="mobileMenuNav">
        <div class="mobileMenuLinks" style="--main_header_color : {{ $settings->main_header_color }};">
            <div class="logoImg">
                @if ($settings->logo)
                    <img src="{{ asset('uploads/Setting/thumbnail/' . $settings->logo) }}" alt="">
                @else
                    <img src="{{ asset('theme/images/logo-big2.png') }}" alt="">
                @endif
            </div>
            <ul class="navbar-primary-menu menu-items-list">

                <li class="">
                    <a href="{{ route('welcome') }}" title="
                             Dashboard" class="active"><span><i data-feather="grid"></i></span><span
                            class="nav-label">Dashboard</span></a>
                </li>
                @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                    @includeIf('layouts.component.role_based_nav.ceo_nav')
                @endif

                @if (Auth::user()->role == 3)
                    @includeIf('layouts.component.role_based_nav.hr_nav')
                @endif

                @if (Auth::user()->role == 4)
                    @includeIf('layouts.component.role_based_nav.lm_nav')
                @endif

                @if (Auth::user()->role == 5)
                    @includeIf('layouts.component.role_based_nav.staff_nav')
                @endif
                @if (Auth::user()->role == 1)
                    <li class="list-item">
                        <p class="report-link">
                            <a style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary" data-toggle="collapse" href="#collapseSetup" role="button"
                               aria-expanded="false" aria-controls="collapseSetup">
                                <span><i data-feather="settings"></i></span><span class="nav-label">Settings</span>
                            </a>
                        </p>
                        <div class="collapse" id="collapseSetup">
                            <div class="card card-body card-design">
                                <ul class="report-submenu list-unstyled">
                                    <li>
                                        <a href="{{ route('company-setting.index') }}"><span
                                                class="list-style"><i data-feather="minus"></i></span>
                                            <span class="nav-label"> Company Setting</span></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('setting.index') }}"><span><i
                                                    data-feather="minus"></i></span>
                                            <span class="nav-label">
                                                Other Settings
                                            </span> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>

                    <li class="list-item">
                        <p class="report-link">
                            <a style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary" data-toggle="collapse" href="#collapseTax" role="button"
                               aria-expanded="false" aria-controls="collapseTax" title="
                             Tax Rules">
                                <span><i data-feather="percent"></i></span><span class="nav-label">Tax Rules</span>
                            </a>
                        </p>
                        <div class="collapse" id="collapseTax">
                            <div class="card card-body card-design">
                                <ul class="report-submenu list-unstyled">
                                    <li>
                                        <a href="{{ route('income-tax.index') }}" title="Income Tax"><span><i
                                                    data-feather="minus"></i></span>
                                            <span class="nav-label">
                                                Income Tax</span> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
        <div class="nav__overlay"></div>
    </nav>
</div>
<div class="desktop-view-header btn-expand-collapse fixNavTop">
    <nav class="navbar navbar-inverse custom-navbar bg-white fixed-top" >
        <a title="Back" href="{{ URL::previous() }}" id="js-top">
            <div class="backIcon">
                <div class="backIconBg">
                    <i data-feather="arrow-left"></i>
                </div>
                <span>Back</span>
            </div>
        </a>
        <div class="header-right">
             <!-- <div class="k360Timmer">
                    <div class="centerFlex">
                   
                        <h6 class="mb-0 mr-3 text-dark"><span id="clock_hour">{{ date('g') }}</span> : <span
                                id="clock_min">{{ date('i') }}</span> : <span
                                id="clock_sec">{{ date('s') }}</span></h6>
                    </div>
                </div> -->
         
            <div class="dropdown show custom-dropdown">
                <a class=" dropdown-toggle p-0" href="#" role="button" id="dropdownNotifyLink" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <span class="screen-reader-text bellIcon"><i data-feather="bell"></i>
                        @if (count($user->unreadNotifications) > 0)
                            <span class="badge badge-danger">{{ count($user->unreadNotifications) }}</span>
                        @endif
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="dropdownNotifyLink"
                     style="min-width: 15rem;">
                    <div class="row">
                        <div class="col-md-12">
                            @if (count($user->unreadNotifications) > 0)
                                @foreach ($user->unreadNotifications->take(5) as $notification)
                                    <div>
                                        <p class="dropdown-item text-dark">
                                            {{ $notification->data['text'] }}</p>
                                    </div>
                                @endforeach
                            @else
                                <div class="noNotifications">
                                    <div>
                                        <i data-feather="bell"></i>
                                        <p class="mb-0 pb-0 text-dark">No New Notification</p>
                                    </div>
                                </div>
                            @endif
                            <hr width="100%">
                        </div>
                        <div class="col-md-12 text-center">
                            <a href="{{ route('notification.all') }}">View All</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dropdown show custom-dropdown">
                <a class="btn dropdown-toggle p-0 mr-3 ml-3" href="#" role="button" id="dropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{--                    <div>--}}
                    {{--                    <span class="huser-name">{{ Auth::user()->name }}</span>--}}

                    {{--                    </div>--}}
                    <div class="d-flex align-items-center">

                        <div class="userInfoNav text-end text-right mr-1">
                            <small style="--main_header_color : {{ $settings->main_header_color }};">Namaste,</small>
                            <p>   {{ Auth::user()->name }}</p>
                        </div>
                        <div class="navUserImg">
                            @if (Auth::user()->profile_image)
                                <img src="{{ asset('uploads/UserDocuments/thumbnail/' . Auth::user()->profile_image) }}"
                                     alt="{{ Auth::user()->name }}'s picture" class="rounded-circle"/>
                            @else
                                <img src="{{ asset('theme/images/user.png') }}" class="rounded-circle">
                            @endif
                        </div>

                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="dropdownMenuLink">
                    <a href="{{ route('profile.profile') }}" class="dropdown-item view-profile">
                        <i data-feather="eye"></i> My Profile</a>
                    <a href="{{ route('user.change.password') }}" class="dropdown-item change-pw">
                        <i data-feather="key"></i> Change Password</a>
                    <a href="{{ route('user.change.pin') }}" class="dropdown-item change-pin">
                        <i data-feather="lock"></i>Change
                        Pin</a>
                    <a href="javascript:void(0);" class="dropdown-item"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            data-feather="log-out"></i> Logout</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            @if ($attendance_status == 'show_clockin')
                <button type="button" title="Clockin" class="btn btn-success btn-clockin"
                        data-user-id="{{ Auth::user()->id }}"><i data-feather="log-in"></i>Clock In
                </button>
            @elseif($attendance_status == 'show_clockout')
                <button type="button" title="Clockout" class="btn btn-danger btn-clockout"
                        data-user-id="{{ Auth::user()->id }}"><i data-feather="log-out"></i>Clock Out
                </button>
            @elseif($attendance_status == 'show_default_clockout')
                <button type="button" title="Old Clockout"
                        style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-default-clockout btn-clockin-white old-clockin "
                        data-user-id="{{ Auth::user()->id }}" data-id="{{ $old_default_clockout->id }}"><i
                        class="fa fa-clock-o"></i></button>
            @endif
        </div>
    </nav>
</div>
