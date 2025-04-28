@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/register.css') }}">

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h2>ユーザー新規登録画面</h2>
        <div class="card-body">
        <form method="POST" action="{{ route('user.register') }}">
                @csrf

                {{-- ユーザー名（user_name） --}}
                <input id="user_name" type="text"
                    class="form-control @error('user_name') is-invalid @enderror"
                    name="user_name"
                    placeholder="名前"
                    value="{{ old('user_name') }}"
                    required autocomplete="user_name" autofocus>

                @error('user_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                {{-- メールアドレス --}}
                <input id="email" type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email"
                    placeholder="メールアドレス"
                    value="{{ old('email') }}"
                    required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                {{-- パスワード --}}
                <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    placeholder="パスワード"
                    required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                {{-- パスワード確認 --}}
                <input id="password-confirm" type="password"
                    class="form-control"
                    name="password_confirmation"
                    placeholder="パスワード(確認用)"
                    required autocomplete="new-password">

                {{-- ボタン --}}
                <div class="button-group mt-3">
                    <button type="submit" class="register-button">新規登録</button>
                    <a href="{{ route('login') }}" class="back-button">戻る</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection