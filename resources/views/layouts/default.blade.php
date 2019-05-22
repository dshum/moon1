<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<title>@yield('title')</title>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="content">
@yield('content')
</div>
</body>
</html>