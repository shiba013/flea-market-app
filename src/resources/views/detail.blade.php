@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail">
    <div class="detail__inner">
        <div class="items__img">
            <img src="{{ asset($item->image) }}">
        </div>

        <article class="detail__group">
            <section class="detail-content">
                <h1 class="detail-content__name">{{ $item->name }}</h1>
                <p class="detail-content__name-p">{{ $item->brand }}</p>
                <p class="detail-content__price-p">¥
                    <span class="detail-content__price-span">{{ number_format($item->price) }}</span>（税込）
                </p>
                <table class="review-table">
                    <tr class="review-table__row">
                        <th>
                            <form action="/item/{{ $item->id }}/like" method="post">
                                @csrf
                                <input type="checkbox" name="like" id="like" class="like-btn">
                                <label for="like">
                                    <img src="{{ asset('icon/star.png') }}" alt="star"
                                    class="like-icon {{ $item->likes->pluck('user_id')->contains(auth()->id()) ? 'liked' : '' }}"
                                    onclick="this.closest('form').submit();">
                                </label>
                            </form>
                        </th>
                        <th>
                            <input type="checkbox" name="comment" id="comment" class="comment-btn">
                            <label for="comment">
                                <img src="{{ asset('icon/speechBub.png') }}" alt="speechBub" class="comment-icon {{ $commented ? 'commented' : '' }}" >
                            </label>
                        </th>
                    </tr>
                    <tr class="review-table__row">
                        <th class="review-table__data">{{ $item->likes->count() }}</th>
                        <th class="review-table__data">{{ $item->comments->count() }}</th>
                    </tr>
                </table>
                <div class="order">
                    <form action="/purchase/{{ $item->id }}" method="get">
                        <input type="submit" value="購入手続きへ" class="order__btn">
                    </form>
                </div>
            </section>

            <section class="detail-content">
                <h2 class="detail-content__description">商品説明</h2>
                <textarea name="description" class="description-area" disabled>{{ $item->description }}</textarea>
            </section>

            <section class="detail-content">
                <h2 class="detail-content__info">商品の情報</h2>
                <table class="info-table">
                    <tr class="info-table__row">
                        <th class="info__title">カテゴリー</th>
                        @foreach($item->categories as $category)
                        <td class="category-td">
                            <p class="category-p">{{ $category->name }}</p>
                        </td>
                    @endforeach
                    </tr>
                </table>
                <table class="info">
                    <tr>
                        <th class="info__title">商品の状態</th>
                        <td class="condition-td">{{ $item->condition->name }}</td>
                    </tr>
                </table>
            </section>

            <section class="detail-content">
                <h2 class="detail-content__comment">コメント（{{ $item->comments->count() }}）</h2>
                @foreach($item->comments as $comment)
                <div class="comment__user">
                    <img src="{{ asset($item->image) }}" class="comment__user-img">
                    <p class="comment__user-p">{{ $comment->user->name }}</p>
                </div>
                <textarea name="" class="read__comment" disabled>{{ $comment->comment }}</textarea>
                @endforeach
                <form action="/item/{{ $item->id }}/comment" method="post" class="comment-form">
                    @csrf
                    <label for="comment" class="write__comment">商品へのコメント</label>
                    <textarea name="comment" id="comment" class="write__comment-area" rows="10">{{ old('comment')}}</textarea>
                    <p class="alert">
                        @error('comment')
                        {{ $message }}
                        @enderror
                    </p>
                    <input type="submit" value="コメントを送信する" class="write__comment-btn">
                </form>
            </section>
        </article>
    </div>
</div>
@endsection