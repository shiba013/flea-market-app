<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required | email | max:255 | unique:users ',
            'password' => 'required | min:8 | confirmed ',
            'password_confirmation' => 'required | min:8 | confirmed '
        ];
    }

    public function messages()
    {
        return [
            'email;.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは、有効なメールアドレス形式で指定してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password_confirmation.required' => '確認用パスワードを入力してください',
            'password_confirmation.min' => '確認用パスワードは8文字以上で入力してください',
            'password_confirmation.confirmed' => 'パスワードが確認用パスワードと一致していません',

        ];
    }
}
