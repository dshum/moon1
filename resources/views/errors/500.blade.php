@extends('layouts.default')

@section('title', '500')

@section('content')
<h1>Ой! Ошибка.</h1>
@if (env('APP_DEBUG') === true)
<p>{{ $exception->getMessage() }}</p>
<p>{{ $exception->getFile() }} ({{ $exception->getLine() }})</p>
<p><small>{!! nl2br($exception->getTraceAsString()) !!}</small></p>
@else
<p>Мы скоро ее исправим.</p>
@endif
@endsection