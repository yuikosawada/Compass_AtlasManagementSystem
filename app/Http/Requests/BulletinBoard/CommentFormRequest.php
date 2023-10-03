<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;


class CommentFormRequest extends FormRequest
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

        'comment'=> 'required|string|max:2500'

        ];

    }

    public function messages()
    {
        return [
            'required' => ':attributeは必ず入力してください。',
            'string' => ':attributeは文字列の型である必要があります。',
            'max' => ':attributeは:max文字以下である必要があります。',
        ];
    }
}
