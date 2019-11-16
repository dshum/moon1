@extends('layouts.default')

@section('title', 'Moon1')

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush

@section('content')
    <h2>Обратная связь</h2>
    @if (session('error') == 'recaptcha')
        <p class="fail">Похоже, вы робот.</p>
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
        <p>
            <label>Текст сообщения:</label><br>
            <textarea name="message" rows="10" class="@error('message') invalid @enderror">{{ old('message') }}</textarea>
        </p>
        <p>
            <label>Имя:</label><br>
            <input type="text" name="face" value="{{ old('face') }}" class="@error('face') invalid @enderror"></p>
        <p>
            <label>E-mail:</label><br>
            <input type="text" name="email" value="{{ old('email') }}" class="@error('email') invalid @enderror">
        </p>
        <p>
            <input type="submit" id="submit" value="Отправить">
        </p>
        <div class="g-recaptcha" data-sitekey="{{ $key }}"></div>
    </form>
@endsection
