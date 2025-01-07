<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileEditRequest extends FormRequest
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
            'name' => ['required'],
            'image' => ['mimes:jpeg,jpg,png', 'nullable']
        ];
    }

    public function messages(){
        return [
            'name.required' => 'ユーザー名を入力してください',
            'image.mimes' => '拡張子が.jpeg .jpg .pngいずれかの画像を選択してください'
        ];
    }
}
