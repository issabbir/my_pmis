<!DOCTYPE html>
<html class="h-100" lang="{{str_replace('_', '-', app()->getLocale())}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{env('APP_NAME', 'CPA')}}</title>
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/cns_favicon.png')}}">
</head>
<body class="h-100">
<div id="app" v-cloak>
    <script src="{{mix('/js/pmis.js')}}" defer></script>
</div>
</body>
</html>
