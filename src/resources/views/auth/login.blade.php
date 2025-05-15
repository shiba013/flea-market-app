<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <title>flea market app</title>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__title">
                <div class="header__logo">
                    <a href="/" class="header__logo-a">
                        <img src="{{ asset('icon/logo.svg') }}" alt="社名ロゴ">
                    </a>
                </div>
            </div>
        </div>
    </header>

    @if(session('message'))
    <div class="session">
        <p class="session__message">
            {{ session('message') }}
        </p>
    </div>
    @endif
    <main class="login">
        <h2 class="login__title">ログイン</h2>
        <div class="login__inner">
            <form action="/login" method="post" class="login-form">
                @csrf
                <div class="login-form__group">
                    <label for="email" class="login-form__label">メールアドレス</label>
                    <input type="text" name="email" id="email" class="login-form__input"
                    value="{{ old('email') }}">
                    <p class="alert">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="login-form__group">
                    <label for="password" class="login-form__label">パスワード</label>
                    <input type="password" name="password" id="password" class="login-form__input"
                    value="{{ old('password') }}">
                    <p class="alert">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="login-form__group">
                    <input type="submit" value="ログインする" class="login-form__btn">
                </div>
                <div class="login-form__group">
                    <a href="/register" class="form__link">会員登録はこちら</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>