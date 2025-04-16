<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'post_code' => 'required | regex:/^[0-9]{3}-?[0-9]{4}$/',
            'address' => 'required',
            'building' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザ名を入力してください',
            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex' => 'ハイフン込みの8文字で入力してください',
            'address.required' => '住所を入力してください',
            'building.required' => '建物名を入力してください',
        ];
    }
}
