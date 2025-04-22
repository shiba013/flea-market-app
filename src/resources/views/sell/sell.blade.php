@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell/sell.css') }}">
@endsection

@section('content')
<div class="sell">
    <h1 class="sell__title">商品の出品</h1>
        <div class="sell__inner">
            <form action="/sell" method="post" class="sell-form" enctype="multipart/form-data">
                @csrf
                <section class="sell-form__group">
                    <label class="sell-form__label">商品画像</label>
                    <div class="image">
                        <label for="image" class="image__label">画像を選択する</label>
                        <input type="file" name="image" id="image" class="image__input">
                    </div>
                    <p class="alert">
                            @error('image')
                            {{ $message }}
                            @enderror
                        </p>
                </section>
                <section class="sell-form__group">
                    <h2 class="sell-form__title">商品の詳細</h2>
                    <label class="sell-form__label">カテゴリー</label>
                    <div class="category__items">
                        @foreach($categories as $category)
                        <input type="checkbox" name="categories[]" id="{{ $category->id }}" value="{{ $category->id }}" class="category__input"
                        {{ (is_array(old('categories')) && in_array($category->id , old('categories'))) ? 'checked' : '' }}>
                        <label for="{{ $category->id }}" class="category__label">{{ $category->name }}</label>
                        @endforeach
                    </div>
                    <p class="alert">
                        @error('categories')
                        {{ $message }}
                        @enderror
                    </p>

                    <label for="post_code" class="sell-form__label">商品の状態</label>
                    <div class="sell-form__select-inner">
                        <select name="condition_id" class="sell-form__select" >
                            <option value="" hidden>選択してください</option>
                            @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}" class="option" {{ old('condition_id')==$condition->id ? 'selected' : '' }}>{{ $condition->name }}</option>
                            @endforeach
                        </select>
                        <p class="alert">
                            @error('condition_id')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
                </section>
                <section class="sell-form__group">
                    <h2 class="sell-form__title">商品名と説明</h2>
                    <label for="name" class="sell-form__label">商品名</label>
                    <input type="name" name="name" id="name" class="sell-form__input" value="{{ old('name') }}">
                    <p class="alert">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </p>

                    <label for="brand" class="sell-form__label">ブランド名</label>
                    <input type="text" name="brand" id="brand" class="sell-form__input" value="{{ old('brand') }}">
                    <p class="alert">
                        @error('brand')
                        {{ $message }}
                        @enderror
                    </p>

                    <label for="description" class="sell-form__label">商品の説明</label>
                    <textarea name="description" id="description" class="sell-form__area" rows="10">{{ old('description') }}</textarea>
                    <p class="alert">
                        @error('description')
                        {{ $message }}
                        @enderror
                    </p>

                    <label for="price" class="sell-form__label">販売価格</label>
                    <input type="text" name="price" id="price" class="sell-form__input" value="{{ old('price') }}">
                    <p class="alert">
                        @error('price')
                        {{ $message }}
                        @enderror
                    </p>
                </section>
                <section class="sell-form__group">
                    <input type="submit" value="出品する" class="sell-form__btn">
                </section>
            </form>
        </div>
</div>
@endsection