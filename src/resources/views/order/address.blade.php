@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/order/address.css') }}">
@endsection

@section('content')
<div class="address">
    <h2 class="address__title">住所の変更</h2>
    <div class="address__inner">
        <form action="/address" method="post" class="address-form">
            @csrf
            <section class="address-form__group">
                <label for="post_code" class="address-form__label">郵便番号</label>
                <input type="text" name="post_code" id="post_code" class="address-form__input">
                <p class="alert">
                    @error('post_code')
                    {{ $message }}
                    @enderror
                </p>
            </section>
            <section class="address-form__group">
                <label for="address" class="address-form__label">住所</label>
                <input type="text" name="address" id="address" class="address-form__input">
                <p class="alert">
                    @error('address')
                    {{ $message }}
                    @enderror
                </p>
            </section>
            <section class="address-form__group">
                <label for="building" class="address-form__label">建物名</label>
                <input type="text" name="building" id="building" class="address-form__input">
                <p class="alert">
                    @error('building')
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