<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
            'image' => ['required', 'mimes:jpeg,jpg,png'],
            'description' => ['required'],
            'condition_id' => ['required'],
            'categories' => ['required', 'array', 'min:1'],
            'price' => ['required', 'integer', 'min:0']
        ];
    }

    public function messages(){
        return [
            'name.required' => '商品名を入力してください',
            'image.required' => '画像を選択してください',
            'image.mimes' => '拡張子が.jpeg .jpg .pngいずれかの画像を選択してください',
            'description.required' => '商品の説明を入力してください',
            'condition_id.required' => '商品の状態を選択してください',
            'categories.required' => 'カテゴリーを少なくとも1つ選択してください',
            'categories.min' => 'カテゴリーを少なくとも1つ選択してください',
            'price.required' => '商品価格を入力してください',
            'price.integer' => '商品価格を数値で入力してください',
            'price.min' => '商品価格を0円以上で入力してください'
        ];
    }
}
