@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/order/address.css') }}">
@endsection

@section('content')
<div class="address">
    <h2 class="address__title">住所の変更</h2>/
    <div class="address__inner">
        <form action="/purchase/address/{{ $item->id }}" method="post" class="address-form">
            @csrf
            <section class="address-form__group">
                <label for="shipping_post_code" class="address-form__label">郵便番号</label>
                <input type="text" name="shipping_post_code" id="shipping_post_code" class="address-form__input">
                <p class="alert">
                    @error('shipping_post_code')
                    {{ $message }}
                    @enderror
                </p>
            </section>
            <section class="address-form__group">
                <label for="shipping_address" class="address-form__label">住所</label>
                <input type="text" name="shipping_address" id="shipping_address" class="address-form__input">
                <p class="alert">
                    @error('shipping_address')
                    {{ $message }}
                    @enderror
                </p>
            </section>
            <section class="address-form__group">
                <label for="shipping_building" class="address-form__label">建物名</label>
                <input type="text" name="shipping_building" id="shipping_building" class="address-form__input">
                <p class="alert">
                    @error('shipping_building')
                    {{ $message }}
                    @enderror
                </p>
            </section>
            <section class="address-form__group">
                <input type="submit" value="更新する" class="address-form__btn">
            </section>
        </form>
    </div>
</div>
@endsection