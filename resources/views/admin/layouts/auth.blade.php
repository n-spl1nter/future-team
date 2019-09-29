<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('assets/admin/css/app.css') }}">
    <title>{{ env('APP_NAME') }}</title>
    @stack('css')
    @yield('head')
</head>
<body class="hold-transition login-page">
@yield('content')
<script src="{{ mix('assets/admin/js/app.js') }}"></script>
@yield('scripts')
@stack('js')
</body>
</html>
