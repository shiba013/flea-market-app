@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/order/purchase.css') }}">
@endsection

@section('content')
<div class="purchase">
    <form action="/mylist" method="post" class="purchase__inner">
        @csrf
        <div class="wrap">
            <section class="purchase__group">
                <div class="purchase__group__inner">
                    <img src="" alt="">
                    <div class="purchase__content">
                        <h2>商品名</h2>
                        <p><span>¥</span>47.000</p>
                    </div>
                </div>
            </section>
            <section class="purchase__group">
                <label class="purchase__label">支払い方法</label>
                <div class="purchase__select--inner">
                    <?php $selected = $_GET['pay'] ?? '未選択'; ?>
                    <form action="" method="get">
                        <select name="pay" class="purchase__select" onchange="location = '?pay=' + this.value;">
                            <option hidden>選択してください</option>
                            <option value="コンビニ支払い" <?php $selected === 'コンビニ支払い' ? 'selected' : '' ?>>コンビニ支払い</option>
                            <option value="カード支払い" <?php $selected == 'カード支払い' ? 'selected' : '' ?>>カード支払い</option>
                        </select>
                    </form>
                </div>
            </section>
            <section class="purchase__group">
                <div class="shipping-address">
                    <label class="purchase__label">配送先</label>
                    <a href="/purchase/address">変更する</a>
                </div>
                <div class="shipping-address--inner">
                    <p class="shipping-address__p"><span>〒</span>{{ old('shipping_post_code', Auth::user()->post_code) }}</p>
                    <input type="hidden" name="" value="">
                    <p class="shipping-address__p">{{ old('shipping_address', Auth::user()->address) }}</p>
                    <p class="shipping-address__p">{{ old('shipping_building', Auth::user()->building) }}</p>
                </div>
            </section>

            <section class="purchase__items">
                <div class="order-info">
                    <div class="order-info__inner">
                        <p class="order-price__p">商品代金</p>
                        <p class="order-price__p"><span>¥</span>47,000</p>
                    </div>
                    <div class="order-info__inner">
                        <p class="order-pay__p">支払い方法</p>
                        <p class="order-pay__p"><?= htmlspecialchars($selected) ?></p>
                    </div>
                </div>
            </section>
            <section class="purchase__items">
                <input type="submit" value="購入する" class="purchase__items-btn">
            </section>
        </div>
    </form>
</div>
@endsection