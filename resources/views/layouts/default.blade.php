<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    @stack('scripts')
</head>
<body>
<div class="content">
    @yield('content')
</div>
<div class="footer">
    Этот сайт использует
    <a href="https://ru.wikipedia.org/wiki/Cookie">файлы cookie</a><br>
    Денис Шумеев, {{ date('Y') }}
</div>
</body>
</html>
