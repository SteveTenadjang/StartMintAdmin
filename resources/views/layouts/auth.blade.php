<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include('partials/head')
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('APP_NAME')}} - Auth</title>
</head>
<body>
    @yield('content')
</body>
</html>
