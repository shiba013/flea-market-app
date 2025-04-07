<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <title>flea market app</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__title">
                <div class="header__logo">
                    <img src="{{ asset('icon/logo.svg') }}" alt="社名ロゴ">
                </div>

                <div class="search">
                    <form action="" method="" class="search-form">
                        @csrf
                        <input type="text" name="keyword" class="search-form__input" placeholder="なにをお探しですか？">
                    </form>
                </div>

                <nav class="nav">
                    <ul class="nav-form">
                        <li class="nav__items">
                            @if(Auth::check())
                            <form action="/logout" method="post">
                                @csrf
                                <input type="submit" value="ログアウト" class="auth__btn">
                            </form>
                            @else
                            <form action="/login" method="get">
                                <input type="submit" value="ログイン" class="auth__btn">
                            </form>
                            @endif
                        </li>
                        <li class="nav__items">
                            <form action="" method="get">
                                <input type="submit" value="マイページ" class="mypage__btn">
                            </form>
                        </li>
                        <li class="nav__items">
                            <form action="" method="get">
                                <input type="submit" value="出品" class="sell__btn">
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>