@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/order/purchase.css') }}">
@endsection

@section('content')
<div class="purchase">
    <form action="/purchase/{{ $item->id }}" method="post" class="purchase__inner">
        @csrf
        <div class="wrap">
            <section class="purchase__group">
                <div class="purchase__group__inner">
                    <img src="{{ asset($item->image) }}">
                    <div class="purchase__content">
                        <h2>{{ $item->name }}</h2>
                        <p><span>¥</span>{{ number_format($item->price) }}</p>
                    </div>
                </div>
            </section>
            <section class="purchase__group">
                <label class="purchase__label">支払い方法</label>
                <div class="purchase__select__inner">
                    <select name="pay" class="purchase__select" id="selectItem">
                        <option value="" hidden>選択してください</option>
                        <option value="1">コンビニ支払い</option>
                        <option value="2">カード支払い</option>
                    </select>
                    <p class="alert">
                        @error('pay')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </section>
            <section class="purchase__group">
                <div class="shipping-address">
                    <label class="purchase__label">配送先</label>
                    <a href="/purchase/address/{{ $item->id }}">変更する</a>
                </div>
                <div class="shipping-address__inner">
                    <span class="shipping-address__span">〒</span>
                    <input type="text" name="shipping_post_code" class="shipping-address__input"
                    value="{{ session('shipping_post_code', Auth::user()->post_code) }}" readonly>
                    <input type="text" name="shipping_post_code" class="shipping-address__input"
                    value="{{ session('shipping_address', Auth::user()->address) }}" readonly>
                    <input type="text" name="shipping_post_code" class="shipping-address__input"
                    value="{{ session('shipping_building', Auth::user()->building) }}" readonly>
                </div>
            </section>

            <section class="purchase__items">
                <div class="order-info">
                    <div class="order-info__inner">
                        <p class="order-price__p">商品代金</p>
                        <p class="order-price__p"><span>¥</span>{{ number_format($item->price) }}</p>
                    </div>
                    <div class="order-info__inner">
                        <p class="order-pay__p">支払い方法</p>
                        <p class="order-pay__p" id="selectedText"></p>
                    </div>
                </div>
            </section>

            <script>
                const selectElement = document.getElementById('selectItem');
                const outputElement = document.getElementById('selectedText');

                selectElement.addEventListener('change', function () {
                const selectedOption = selectElement.options[selectElement.selectedIndex].text;
                outputElement.textContent = selectedOption;
                });
            </script>

            <section class="purchase__items">
                <input type="submit" value="購入する" class="purchase__items-btn">
            </section>
        </div>
    </form>
</div>
@endsection