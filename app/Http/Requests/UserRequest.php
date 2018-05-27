<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id(),
            'email' => 'required|email',
            'introduction' => 'max:80',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200',
        ];
    }

    public function messages()
    {
        return [
            'avatar.mimes' =>'プロフィール画像は jpeg, jpg, png, gif を使用してください。',
            'avatar.dimensions' => '画像サイズは横幅200px以上、縦200px以上必要です。',
            'name.unique' => 'すでに使われてユーザ名です。',
            'name.regex' => 'ユーザ名は英数字、下線 (_)、ハイフン (-) のみ入力してください。',
            'name.between' => 'ユーザ名は 3 - 25 文字を入力してください。',
            'name.required' => 'ユーザ名が必須です。',
        ];
    }
}
