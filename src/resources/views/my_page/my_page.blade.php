@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page/my_page.css') }}">
@endsection

@section('content')
<?php $tab = $tab ?? ''; ?>
<div class="content">
    <div class="edit-profile">
        <form action="/mypage/profile" method="get" class="edit-form">
            <div class="edit-form__item">
                <img src="{{ asset($user->image) }}" class="edit-form__img">
                <p class="edit-form__p">{{ Auth::user()->name }}</p>
                <input type="submit" value="プロフィールを編集" class="edit-form__input">
            </div>
        </form>
    </div>
    <div class="top__title">
        <div class="title-list">
            <input type="radio" name="name-tab" id="sell" {{ $tab == 'sell' ? 'checked' : '' }}>
            <label for="sell" class="title__name">
                <a href="/mypage/?tab=sell">出品した商品</a>
            </label>
            <input type="radio" name="name-tab" id="buy" {{ $tab == 'buy' ? 'checked' : '' }}>
            <label for="buy" class="title__name">
                <a href="/mypage/?tab=buy">購入した商品</a>
            </label>
        </div>
    </div>
    @if($tab == 'sell')
    <div class="sell">
        <div class="items-list__inner">
            @foreach($items as $item)
            <form action="/item/{{ $item->id }}" method="get" class="items-form" enctype="multipart/form-data">
                <button type="submit" class="items__btn">
                    <img src="{{ asset($item->image) }}">
                    @if($item->is_sold == 1)
                    <div class="sold">
                        <p class="sold__label">Sold</p>
                    </div>
                    @endif
                    <p class="items__name">{{ $item->name }}</p>
                </button>
            </form>
            @endforeach
        </div>
    </div>
    @elseif($tab == 'buy')
    <div class="buy">
        <div class="items-list__inner">
            @foreach($items as $item)
            <form action="/item/{{ $item->id }}" method="get" class="items-form" enctype="multipart/form-data">
                <button type="submit" class="items__btn">
                    <img src="{{ asset($item->image) }}">
                    @if($item->is_sold == 1)
                    <div class="sold">
                        <p class="sold__label">Sold</p>
                    </div>
                    @endif
                    <p class="items__name">{{ $item->name }}</p>
                </button>
            </form>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection