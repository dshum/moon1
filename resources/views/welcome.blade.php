@extends('layouts.default')

@section('title', 'Moon1')

@section('content')
    <script src="https://www.google.com/recaptcha/api.js?render={{ $key }}"></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute("{{ $key }}", {action: 'homepage'}).then(function (token) {
                $('form[name="messageForm"] input[name="recaptcha"]').val(token);
            });
        });
    </script>
    <h2>Обратная связь</h2>
    @if (session('error') == 'recaptcha')
        <p class="fail">Похоже, вы робот.<p>
    @elseif ($errors->any())
        <p class="fail">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </p>
    @elseif (session('status') == 'sent')
        <p class="success">Ваше сообщение отправлено.</p>
    @endif
    <form name="messageForm" action="{{ route('message') }}" method="post">
        @csrf()
        <input type="hidden" name="recaptcha" value="">
        <p><label>Текст сообщения:</label><br>
            <textarea name="message" rows="10" class="@error('message') invalid @enderror">{{ old('message') }}</textarea>
        </p>
        <p><label>Имя:</label><br>
            <input type="text" name="face" value="{{ old('face') }}" class="@error('face') invalid @enderror"></p>
        <p><label>E-mail:</label><br>
            <input type="text" name="email" value="{{ old('email') }}" class="@error('email') invalid @enderror"></p>
        <p><input type="submit" value="Отправить"></p>
    </form>
@endsection
