@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/order/purchase.css') }}">
@endsection

@section('content')
<div class="purchase">
    <form action="" method="post" class="purchase__inner">
        @csrf
        <section class="purchase__group">
            <div class="purchase__group__inner">
                <img src="" alt="">
                <div class="purchase__content">
                    <h2>商品名</h2>
                    <p><span>¥ </span>47,000</p>
                </div>
            </div>
        </section>
        <section class="purchase__group">
            <label for="" class="purchase__label">支払い方法</label>
            <div class="purchase__select--inner">
                <select name="pay" id="" class="purchase__select">
                    <option hidden>選択してください</option>
                    {{--@foreach($orders as $order)--}}
                    <option value=""></option>
                    {{--@endforeach--}}
                </select>
            </div>
        </section>
        <section class="purchase__group">
            <div class="shipping-address">
                <label for="" class="purchase__label">配送先</label>
                <a href="">変更する</a>
            </div>
            <div class="shipping-address--inner">
                <p class="shipping-address__p">〒　</p>
                <p class="shipping-address__p">住所を入れる</p>
                <p class="shipping-address__p">建物名を入れる</p>
            </div>
        </section>

        <div class="purchase__items">
            <div class="order-info">
                <div class="order-info__inner">
                    <p class="order-info__p">商品代金</p>
                    <p class="order-info__p">¥　47,000</p>
                </div>
                <div class="order-info__inner">
                    <p class="order-info__p">支払い方法</p>
                    <p class="order-info__p">コンビニ払い</p>
                </div>
            </div>
        </div>
        <div class="purchase__items">
            <input type="submit" value="購入する" class="purchase__items-btn">
        </div>
    </form>
</div>
@endsection