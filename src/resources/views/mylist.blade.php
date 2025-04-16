@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mylist.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="top__title">
        <div class="title-list">
            <a href="/?tab=all">
                <input type="radio" name="name-tab" id="recommend" checked>
                <label for="recommend" class="title__name">おすすめ</label>
            </a>
            <a href="/?tab=mylist">
                <input type="radio" name="name-tab" id="my-list">
                <label for="my-list" class="title__name">マイリスト</label>
            </a>
        </div>
    </div>
    <div class="items-list">
        <div class="items-list__inner">
            @foreach($items as $item)
            <form action="/item/{{ $item->id }}" method="get" class="items-form" enctype="multipart/form-data">
                <button type="submit" class="items__btn">
                    <img src="{{ asset($item->image) }}">
                    <p class="items__name">{{ $item->name }}</p>
                </button>
            </form>
            @endforeach
        </div>
    </div>
</div>
@endsection