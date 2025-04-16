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
                    <span class="detail-content__price-span">{{ $item->price }}</span>（税込）
                </p>
                <table class="review-table">
                    <tr class="review-table__row">
                        <th>
                            <input type="checkbox" name="like" id="like" class="like-btn">
                            <label for="like">
                                <img src="{{ asset('icon/star.png') }}" alt="star" class="like-icon">
                            </label>
                        </th>
                        <th>
                            <input type="checkbox" name="comment" id="comment" class="comment-btn">
                            <label for="comment">
                                <img src="{{ asset('icon/speechBub.png') }}" alt="speechBub" class="comment-icon">
                            </label>
                        </th>
                    </tr>
                    <tr class="review-table__row">
                        <th class="review-table__data">1</th>
                        <th class="review-table__data">5</th>
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
                <h2 class="detail-content__comment">コメント（1）</h2>
                <div class="comment__user">
                    <img src="" class="comment__user-img">
                    <p class="comment__user-p">user name</p>
                </div>
                <textarea name="" class="read__comment" disabled>コメントを表示</textarea>

                <form action="" method="post" class="comment-form">
                    @csrf
                    <label for="comment" class="write__comment">商品へのコメント</label>
                    <textarea name="comment" id="comment" class="write__comment-area" rows="10">ここにコメントを記載</textarea>
                    <input type="submit" value="コメントを送信する" class="write__comment-btn">
                </form>
            </section>
        </article>
    </div>
</div>
@endsection