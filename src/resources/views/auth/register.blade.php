<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <title>flea market app</title>
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
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

    <main class="register">
        <h2 class="register__title">会員登録</h2>
        <div class="register__inner">
            <form action="/register" method="post" class="register-form">
                @csrf
                <div class="register-form__group">
                    <label for="name" class="register-form__label">ユーザ名</label>
                    <input type="text" name="name" id="name" class="register-form__input">
                    <p class="alert">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="register-form__group">
                    <label for="email" class="register-form__label">メールアドレス</label>
                    <input type="text" name="email" id="email" class="register-form__input">
                    <p class="alert">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="register-form__group">
                    <label for="password" class="register-form__label">パスワード</label>
                    <input type="password" name="password" id="password" class="register-form__input">
                    <p class="alert">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="register-form__group">
                    <label for="password_confirmation" class="register-form__label">確認用パスワード</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="register-form__input">
                    <p class="alert">
                        @error('password_confirmation')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="register-form__group">
                    <input type="submit" value="登録する" class="register-form__btn">
                </div>
                <div class="register-form__group">
                    <a href="/login" class="form__link">ログインはこちら</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>