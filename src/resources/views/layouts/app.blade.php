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
                    <a href="/" class="header__logo-a">
                        <img src="{{ asset('icon/logo.svg') }}" alt="社名ロゴ">
                    </a>
                </div>

                <div class="search">
                    <form action="/search" method="get" class="search-form">
                        @csrf
                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="search-form__input" placeholder="なにをお探しですか？">
                        <input type="hidden" name="tab" value="{{ request('tab') }}">
                        <input type="image" src="{{ asset('icon/search.png') }}" alt="検索ボタン" class="search-form__btn" width="25" height="25">
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
                            <a href="/login" class="auth__btn">ログイン</a>
                            @endif
                        </li>
                        <li class="nav__items">
                            <a href="/mypage" class="mypage__btn">マイページ</a>
                        </li>
                        <li class="nav__items">
                            <button type="submit" class="sell__btn">
                                <a href="/sell" class="sell__link">出品</a>
                            </button>
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