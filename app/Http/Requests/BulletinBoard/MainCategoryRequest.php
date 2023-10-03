<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;


class MainCategoryRequest extends FormRequest
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

        'main_category_name'=> 'required|string|max:100|unique:main_categories,main_category'

        ];

    }

    public function messages()
    {
        return [
            'required' => ':attributeは必ず入力してください。',
            'string' => ':attributeは文字列の型である必要があります。',
            'unique' => ':attributeは既に登録されています。',
            'min' => ':attributeは:min文字以上である必要があります。',
            'max' => ':attributeは:max文字以下である必要があります。',
            'different' => 'この:attributeはすでに登録済みです。'
        ];
    }
}
