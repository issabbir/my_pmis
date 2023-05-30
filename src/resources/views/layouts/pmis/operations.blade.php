<!DOCTYPE html>
<html class="h-100" lang="{{str_replace('_', '-', app()->getLocale())}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>CPA - @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/swiper.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/semi-dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/dashboard-ecommerce.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/dashboard-analytics.min.css">
    <link rel="stylesheet" type="text/css" href="https://rawgit.com/lykmapipo/themify-icons/master/css/themify-icons.css">
     <link href="{{mix('css/app.css')}}" rel="stylesheet">
    <!-- END: Theme CSS-->
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
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


        <script src="{{mix('/js/pmis_operations.js')}}" defer></script>
        <script>
            jQuery(document).ready(function () {
                activeMenu();
                 jQuery(window).on('hashchange', function() {
                        activeMenu();
                     });
                       function activeMenu() {
                         let hash = window.location.hash;
                         jQuery('.navigation-main a').closest('li').removeClass('active');
                         jQuery('.navigation-main a[href=\"/pmis/operations' + hash + '\"]').closest('li').addClass('sidebar-group-active open active');
                       }
             });
         </script>
    @show
</div>
</body>
</html>
