<!DOCTYPE html>
<html class="h-100" lang="{{str_replace('_', '-', app()->getLocale())}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>CPA - @yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/cns_favicon.png')}}">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/vendors.min.css') }}">

    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/components.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/themes/dark-layout.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/themes/semi-dark-layout.min.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/pages/dashboard-analytics.min.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/plugins/forms/validation/form-validation.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/plugins/forms/wizard.min.css') }}">

    <style>
        .fc-day-grid-event .fc-content {
            background-color: red;
        }
        .fc-day-grid-event .fc-time {
            display: none;
            color: #fff !important;
        }
        .fc-day-grid-event .fc-title {
            color: #fff !important;
            background-color: red;

        }
        .fc-day-grid-event .fc-content {
            white-space: normal !important;
        }
        .fc-day.fc-widget-content.fc-fri{
            background-color: aliceblue !important;
        }
        .fc-day.fc-widget-content.fc-sat{
            background-color: aliceblue !important;
        }
    </style>
    <!-- END: Page CSS-->

    <link href="{{mix('css/app.css')}}" rel="stylesheet">

</head>

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-sticky footer-static  "
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">
<div v-cloak>
    <div class="header-navbar-shadow"></div>
    @section('topbar')
        @include('layouts.partials.topbar');
    @show
    <!-- END: Header-->

    @section('sidebar')
    <!-- BEGIN: Main Menu-->
        @include('layouts.partials.sidebar');
    @show

    <!-- BEGIN: Content-->
        <div class="app-content content mt-3">
        <div class="content-overlay mt-5"></div>
            @yield('content')
    </div>
    <!-- END: Content-->

    @section('footer')
        @include('layouts.partials.footer');
    @show

    @section('js')
          <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('/app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js') }}"></script>
    <script src="{{ asset('/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js') }}"></script>
    <script src="{{ asset('/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script>
           <!-- END Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('/app-assets/js/scripts/configs/vertical-menu-light.min.js') }}"></script>
    <script src="{{ asset('/app-assets/js/core/app-menu.min.js') }}"></script>
    <script src="{{ asset('/app-assets/js/core/app.min.js') }}"></script>

    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->

    <!-- END: Page JS-->
              <script src="{{mix('/js/leave.js')}}" defer></script>
                <script>
                    jQuery(document).ready(function () {
                        activeMenu();
                        jQuery(window).on('hashchange', function() {
                                activeMenu();
                            });
                               function activeMenu() {
                                 let hash = window.location.hash;
                                 jQuery('.navigation-main a').closest('li').removeClass('active');
                                 jQuery('.navigation-main a[href=\"/leave' + hash + '\"]').closest('li').addClass('sidebar-group-active open active');
                               }
                     });
                 </script>

    @show
</div>
</body>
</html>
