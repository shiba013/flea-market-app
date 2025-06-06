<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <title>flea market app</title>
    <link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
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

    <main class="verify-email">
        <h2 class="verify-email__title">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
        </h2>
        <div class="verify-email__inner">
            <form action="/email/verify/resend" method="post" class="verify-email-form">
                @csrf
                <div class="verify-email-form__group">
                    <input type="submit" value="認証メールを再送する" class="verify-email-form__btn">
                </div>
            </form>
        </div>
    </main>
</body>
</html>