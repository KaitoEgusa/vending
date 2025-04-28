@extends('layouts.app')

<link rel = "stylesheet" href = "{{ asset('css/login.css') }}">

@section('content')
<div class = "container">
                <h2>ユーザーログイン画面</h2>

                <div class = "card-body">
                    <form method = "POST" action = "{{ route('login') }}">
                        @csrf

                            <input id = "password" type = "password"class = "form-control @error('password') is-invalid @enderror" name = "password" placeholder = "パスワード"  required autocomplete = "current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <input id = "email" type = "email"class = "form-control @error('email') is-invalid @enderror"name = "email" value = "{{ old('email') }}" placeholder = "アドレス"  required autocomplete = "email" autofocus>
                            @error('email')
                                <div class = "invalid-feedback">{{ $message }}</div>
                            @enderror
                        <div class = "button-group">
    <a href="{{ route('register') }}" class = "register-button">新規登録</a>
    <button type = "submit" class = "login-button">ログイン</button>
</div>

                    </form>
                </div>
            </div>
</div>
@endsection