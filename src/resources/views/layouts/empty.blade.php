<!DOCTYPE html>
<html class="h-100" lang="{{str_replace('_', '-', app()->getLocale())}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>CPA - @yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/cns_favicon.png')}}">
      <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.min.css">
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    <style>
        @yield('style')
    </style>

</head>

<body>

    <!-- BEGIN: Content-->
         <div class="content-overlay mt-5">
            @yield('content')
         </div>
    <!-- END: Content-->

    @section('js')

    @show
</body>
</html>
