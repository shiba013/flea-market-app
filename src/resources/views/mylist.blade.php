@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mylist.css') }}">
@endsection

@section('content')
<?php $tab = $tab ?? ''; ?>
@if(session('message'))
<div class="alert">
    <p class="alert__session">
        {{ session('message') }}
    </p>
</div>
@endif
<div class="content">
    <div class="top__title">
        <div class="title-list">
                <input type="radio" name="name-tab" id="all" {{ $tab == '' ? 'checked' : '' }}>
                <label for="all" class="title__name">
                    @if(request('keyword'))
                    <a href="/search?tab=&keyword={{ request('keyword') }}">おすすめ</a>
                    @else
                    <a href="/">おすすめ</a>
                    @endif
                </label>
                <input type="radio" name="name-tab" id="my-list" {{ $tab == 'mylist' ? 'checked' : '' }}>
                <label for="my-list" class="title__name">
                    @if(request('keyword'))
                    <a href="/search?tab=mylist&keyword={{ request('keyword') }}">マイリスト</a>
                    @else
                    <a href="/?tab=mylist">マイリスト</a>
                    @endif
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