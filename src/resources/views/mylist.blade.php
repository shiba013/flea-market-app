@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mylist.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="top__title">
        <div class="title-list">
            <input type="radio" name="name-tab" id="recommend" checked>
            <label for="recommend" class="title__name">おすすめ</label>
            <a href="/">
            <input type="radio" name="name-tab" id="my-list">
            <label for="my-list" class="title__name">マイリスト</label>
            </a>
        </div>
    </div>
    <div class="items-list">
        <div class="items-list__inner">
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