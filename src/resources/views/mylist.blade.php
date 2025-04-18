@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mylist.css') }}">
@endsection

@section('content')
<?php $tab = $tab ?? ''; ?>
<div class="content">
    <div class="top__title">
        <div class="title-list">
                <input type="radio" name="name-tab" id="all" {{ $tab == '' ? 'checked' : '' }}>
                <label for="all" class="title__name">
                    <a href="/">おすすめ</a>
                </label>
                <input type="radio" name="name-tab" id="my-list" {{ $tab == 'mylist' ? 'checked' : '' }}>
                <label for="my-list" class="title__name">
                    <a href="/?tab=mylist">マイリスト</a>
                </label>
        </div>
    </div>
    @if($tab == 'mylist')
    <div class="my-list">
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
    @else
    <div class="items-list">
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