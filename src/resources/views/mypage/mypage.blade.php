@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/mypage.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="edit-profile">
        <form action="/mypage/profile" method="get" class="edit-form">
            <div class="edit-form__item">
                <img src="" alt="" class="edit-form__img">
                <p class="edit-form__p">{{ Auth::user()->name }}</p>
                <input type="submit" value="プロフィールを編集" class="edit-form__input">
            </div>
        </form>
    </div>
    <div class="top__title">
        <div class="title-list">
            <input type="radio" name="name-tab" id="recommend" checked>
            <label for="recommend" class="title__name">出品した商品</label>
            <a href="/">
            <input type="radio" name="name-tab" id="my-list">
            <label for="my-list" class="title__name">購入した商品</label>
            </a>
        </div>
    </div>
    <div class="items-list">
        <div class="items-list__inner">
            <form action="/detail" method="get" class="items-form">
                <button type="submit" class="items__btn">
                    <img src="" alt="">
                    <p class="items__name">商品名</p>
                </button>
            </form>
            <form action="" method="get" class="items-form">
                <button type="submit" class="items__btn">
                    <img src="" alt="">
                    <p class="items__name">商品名</p>
                </button>
            </form>
            <form action="" method="get" class="items-form">
                <button type="submit" class="items__btn">
                    <img src="" alt="">
                    <p class="items__name">商品名</p>
                </button>
            </form>
            <form action="" method="get" class="items-form">
                <button type="submit" class="items__btn">
                    <img src="" alt="">
                    <p class="items__name">商品名</p>
                </button>
            </form>
            <form action="" method="get" class="items-form">
                <button type="submit" class="items__btn">
                    <img src="" alt="">
                    <p class="items__name">商品名</p>
                </button>
            </form>
            <form action="" method="get" class="items-form">
                <button type="submit" class="items__btn">
                    <img src="" alt="">
                    <p class="items__name">商品名</p>
                </button>
            </form>
            <form action="" method="get" class="items-form">
                <button type="submit" class="items__btn">
                    <img src="" alt="">
                    <p class="items__name">商品名</p>
                </button>
            </form>
        </div>
    </div>

    <div class="items-list">
        <div class="items-list__inner" id="my-list">
            <form action="" method="get" class="items-form">
                <button type="submit" class="items__btn">
                    <img src="" alt="">
                    <p class="items__name">商品名</p>
                </button>
            </form>
            <form action="" method="get" class="items-form">
                <button type="submit" class="items__btn">
                    <img src="" alt="">
                    <p class="items__name">商品名</p>
                </button>
            </form>
            <form action="" method="get" class="items-form">
                <button type="submit" class="items__btn">
                    <img src="" alt="">
                    <p class="items__name">商品名</p>
                </button>
            </form>
            <form action="" method="get" class="items-form">
                <button type="submit" class="items__btn">
                    <img src="" alt="">
                    <p class="items__name">商品名</p>
                </button>
            </form>
            <form action="" method="get" class="items-form">
                <button type="submit" class="items__btn">
                    <img src="" alt="">
                    <p class="items__name">商品名</p>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection