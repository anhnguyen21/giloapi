<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'account' => 'required|max:20|min:5',
            'password' => 'required|max:20|min:5',
        ],[
            'account.required' => 'Tài khoản rỗng',
            'account.max' => 'Tài khoản quá 20 kí tự',
            'account.max' => 'Tài khoản ít hơn 5 kí tự',
            'password.required' => 'Mật khẩu rỗng',
            'password.max' => 'Mật khẩu quá 20 kí tự',
            'password.max' => 'Mật khẩu ít hơn 5 kí tự',
        ];
    }
}
