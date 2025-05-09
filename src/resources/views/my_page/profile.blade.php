@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page/profile.css') }}">
@endsection

@section('content')
<div class="profile">
    <h2 class="profile__title">プロフィール設定</h2>
    <div class="profile__inner">
        <form action="/mypage/profile" method="post" class="profile-form" enctype="multipart/form-data">
            @csrf
            <section class="profile-form__group">
                <div class="image">
                    <div class="image__group">
                        @if(!empty($user->image))
                        <img src="{{ asset($user->image) }}" class="image__img">
                        @endif
                        <input type="file" name="image" id="image" class="image__input">
                    </div>
                    <label for="image" class="image__label">画像を選択する</label>
                    <p class="alert">
                        @error('image')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </section>
            <section class="profile-form__group">
                <label for="name" class="profile-form__label">ユーザ名</label>
                <input type="text" name="name" id="name" class="profile-form__input" value="{{ Auth::user()->name }}">
                <p class="alert">
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </section>
            <section class="profile-form__group">
                <label for="post_code" class="profile-form__label">郵便番号</label>
                <input type="text" name="post_code" id="post_code" class="profile-form__input"
                value="{{ old('post_code', Auth::user()->post_code) }}">
                <p class="alert">
                    @error('post_code')
                    {{ $message }}
                    @enderror
                </p>
            </section>
            <section class="profile-form__group">
                <label for="address" class="profile-form__label">住所</label>
                <input type="text" name="address" id="address" class="profile-form__input"
                value="{{ old('address', Auth::user()->address) }}">
                <p class="alert">
                    @error('address')
                    {{ $message }}
                    @enderror
                </p>
            </section>
            <section class="profile-form__group">
                <label for="building" class="profile-form__label">建物名</label>
                <input type="text" name="building" id="building" class="profile-form__input"
                value="{{ old('building', Auth::user()->building) }}">
                <p class="alert">
                    @error('building')
                    {{ $message }}
                    @enderror
                </p>
            </section>
            <section class="profile-form__group">
                <input type="submit" value="更新する" class="profile-form__btn">
            </section>
        </form>
    </div>
</div>
@endsection