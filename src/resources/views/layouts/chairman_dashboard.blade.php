<!DOCTYPE html>
<html class="h-100" lang="{{str_replace('_', '-', app()->getLocale())}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>CPA - @yield('title')</title>
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/cns_favicon.png')}}">
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
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">

    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    <!-- END: Theme CSS-->
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">

    <!--  Fonts and icons     -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/st.action-panel.css">
    <style>
        html body .content {
            margin-left: 0px !important;
        }
        .header-navbar.fixed-top {
            left:0px !important;
        }
        .bg-rgba-primary {
            background: #283593 !important;
            color: white;
        }
        .card .card-title {
            color: #fff;
        }
        .ficon.bx-fullscreen{
            color: #fff;
        }
        .ficon.bx-exit-fullscreen{
            color: #fff;
        }
        .modified_center {
            font-size: 25px;
            color: #283593 !important;
            position: absolute;left: 50%;
            top: 70%;
            transform: translate(-70%, -50%); padding: 10px;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-sticky footer-static  "
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">
<div v-cloak>
    <div class="header-navbar-shadow"></div>
    @section('topbar')
        @include('layouts.partials.cmtopbar');
    @show
<!-- END: Header-->

<!-- BEGIN: Content-->
    <div class="app-content content mt-5" style="overflow: revert;">
        <div class="content-overlay mt-5"></div>
        @yield('content')
    </div>
    <!-- END: Content-->

    @section('footer')
        @include('layouts.partials.footer');
    @show
    @include('layouts.partials.dashboard_quick_menu');
    @section('js')
    <!-- BEGIN: Vendor JS-->
        <script src="{{ asset('/app-assets/vendors/js/vendors.min.js') }}"></script>
        <script src="{{ asset('/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js') }}"></script>
        <script src="{{ asset('/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js') }}"></script>
        <script src="{{ asset('/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script>
        <!-- END Vendor JS-->

        <script src="{{asset('/app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
        <script src="{{asset('/app-assets/vendors/js/extensions/dragula.min.js')}}"></script>
        <script src="{{asset('/app-assets/vendors/js/charts/chart.min.js')}}"></script>
        <script src="{{asset('/app-assets/js/scripts/pages/dashboard-analytics.min.js')}}"></script>
        <script src="{{asset('/app-assets/js/scripts/pages/dashboard-ecommerce.min.js')}}"></script>

        <!-- BEGIN: Theme JS-->
        <script src="{{ asset('/app-assets/js/scripts/configs/vertical-menu-light.min.js') }}"></script>
        <script src="{{ asset('/app-assets/js/core/app-menu.min.js') }}"></script>
        <script src="{{ asset('/app-assets/js/core/app.min.js') }}"></script>
        <script src="{{asset('/app-assets/js/scripts/charts/chart-chartjs.min.js')}}"></script>
        <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
        <script src="{{asset('/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('/app-assets/vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
        <script src="{{asset('/app-assets/vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
        <script src="{{asset('/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
        <script src="{{asset('/app-assets/vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
        <script src="{{asset('/app-assets/vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
        <script src="{{asset('/app-assets/js/scripts/datatables/datatable.min.js')}}"></script>
        <script src="{{asset('/app-assets/js/scripts/cmdb1.js')}}" defer></script>
        <script src="{{asset('/app-assets/js/scripts/cmdb2.js')}}" defer></script>
        <script src="{{asset('/app-assets/js/scripts/st.action-panel.js')}}" defer></script>

        <script>
            $(document).ready(function(){
                $('st-actionContainer').launchBtn( { openDuration: 500, closeDuration: 300 } );
            });
            jQuery(document).ready(function () {
                activeMenu();
                jQuery(window).on('hashchange', function() {
                    activeMenu();
                });
                function activeMenu() {
                    let hash = window.location.hash;
                    jQuery('.navigation-main a').closest('li').removeClass('active');
                    jQuery('.navigation-main a[href=\"/pmis' + hash + '\"]').closest('li').addClass('sidebar-group-active open active');
                }
            });
        </script>
        <script>

        </script>
        <script>

        </script>
{{--        <script>--}}
{{--            var ctx = document.getElementById("SevenDaysCollection").getContext("2d");--}}

{{--            var seven_days_data = {--}}
{{--                labels: ["21-DEC-21", "22-DEC-21", "23-DEC-21", "24-DEC-21", "25-DEC-21", "26-DEC-21", "27-DEC-21"],--}}
{{--                datasets: [{--}}
{{--                    label: "FCL",--}}
{{--                    backgroundColor: "#5A8DEE",--}}
{{--                    data: [--}}
{{--                        310, 340, 320, 320, 315, 250, 300--}}
{{--                    ]--}}
{{--                }, {--}}
{{--                    label: "LCL",--}}
{{--                    backgroundColor: "#4BC0C0",--}}
{{--                    data: [--}}
{{--                        150, 310, 320, 315, 320, 240, 190--}}
{{--                    ]--}}
{{--                }]--}}
{{--            };--}}

{{--            var myoption = {--}}
{{--                tooltips: {--}}
{{--                    enabled: true--}}
{{--                },--}}
{{--                hover: {--}}
{{--                    animationDuration: 1--}}
{{--                },--}}
{{--                animation: {--}}
{{--                    duration: 1,--}}
{{--                    onComplete: function () {--}}
{{--                        var chartInstance = this.chart,--}}
{{--                            ctx = chartInstance.ctx;--}}
{{--                        ctx.textAlign = 'center';--}}
{{--                        ctx.fillStyle = "rgba(0, 0, 0, 1)";--}}
{{--                        ctx.textBaseline = 'bottom';--}}
{{--                        // Loop through each data in the datasets--}}
{{--                        this.data.datasets.forEach(function (dataset, i) {--}}
{{--                            var meta = chartInstance.controller.getDatasetMeta(i);--}}
{{--                            meta.data.forEach(function (bar, index) {--}}
{{--                                var data = dataset.data[index];--}}
{{--                                ctx.fillText(data, bar._model.x, bar._model.y - 5);--}}
{{--                            });--}}
{{--                        });--}}
{{--                    }--}}
{{--                }--}}
{{--            };--}}

{{--            var employeeDetailsBarChart = new Chart(ctx, {--}}
{{--                type: 'bar',--}}
{{--                data: seven_days_data,--}}
{{--                options: myoption--}}
{{--            });--}}
{{--        </script>--}}

    @show

    @yield('script')
</div>
</body>
</html>
