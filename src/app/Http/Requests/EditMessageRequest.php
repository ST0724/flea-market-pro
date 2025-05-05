<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditMessageRequest extends FormRequest
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
             'edit_text' => ['required', 'max:400'],
        ];
    }

    public function messages(){
        return [
            'edit_text.required' => '本文を入力してください',
            'edit_text.max' => '本文は400文字以内で入力してください',
        ];
    }
}
