<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
<div class="content">
    @yield('content')
</div>
<div class="footer">
    This site is protected by reCAPTCHA and the Google
    <a href="https://policies.google.com/privacy">Privacy Policy</a> and
    <a href="https://policies.google.com/terms">Terms of Service</a> apply.<br> Этот сайт использует
    <a href="https://ru.wikipedia.org/wiki/Cookie">файлы cookie</a>.<br> Денис Шумеев, {{ date('Y') }}
</div>
</body>
</html>
