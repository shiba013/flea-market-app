<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required | regex:/^[0-9]+$/ | min:1',
            'image' => 'required | mimes:png,jpeg',
            'description' => 'required | max:255',
            'categories' => 'required | array',
            'condition_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '販売価格を入力してください',
            'price.regex' => '数値で入力してください',
            'price.min' => '0円以上で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.mimes' => '[.png」または「.jpeg」形式でアップロードしてください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '255文字以内で入力してください',
            'categories.required' => 'カテゴリーを選択してください',
            'condition_id.required' => '商品の状態を選択してください',
        ];
    }
}
