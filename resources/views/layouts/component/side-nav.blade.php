<?php
$nav_bar_collapsed = '';
if (in_array(Route::currentRouteName(), ['attendance.monthly', 'user.index', 'reports.salary-sheet'])) {
    $nav_bar_collapsed = 'collapsed';
}
?>
<nav class="navbar-primary bg-blue collapsed" style="--main_header_color : {{ $settings->main_header_color }};">
    <a href="{{ route('welcome') }}">

        @if ($settings->logo)
            <div class="hrprologoFavOnly">
                <img src="{{ asset('uploads/Setting/thumbnail/' . $settings->logo) }}" alt="">
            </div>
            <div class="hrprologo nav-label">
                <img src="{{ asset('uploads/Setting/thumbnail/' . $settings->logo) }}" alt="">
            </div>
        @else
            <div class="d-flex align-items-center">
                <div class="hrFavLogo">
                    <img src="{{ asset('theme/images/logo-small.png') }}" alt="">
                </div>
                <div class="nav-label">
                    <div class="hrSidebarLogo">
                        <img src="{{ asset('theme/images/hrtext.png') }}" alt="">
                    </div>
                </div>
            </div>
        @endif


    </a>
    <ul class="navbar-primary-menu menu-items-list mt-3">
        <li class="list-item pt-0 menuIc">
            <a href="javascript:void(0);" class="btn-expand-collapse hamburger-menu pt-0">
                <i data-feather="menu"></i>
            </a>
        </li>
        <li class="mt-5 pt-2">
            <a href="{{ route('welcome') }}" title="Dashboard" class="active"
                style="--sec_header_color : {{ $settings->sec_header_color }};">
                <span><i data-feather="grid"></i></span><span class="nav-label">Dashboard</span>
            </a>
        </li>
        @if (Auth::user()->role == 1)
            @includeIf('layouts.component.role_based_nav.superadmin_nav')
        @endif
        @if (Auth::user()->role == 2)
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
                <a href="{{ route('setting.index') }}"><span><i data-feather="settings"></i></span><span
                        class="nav-label">Other Settings</span></a>
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
                                <a href="{{ route('income-tax.index') }}" title="
                             Income Tax"><span><i data-feather="minus"></i></span>
                                    <span class="nav-label">
                                        Income Tax</span> </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        @endif
    </ul>
</nav>
