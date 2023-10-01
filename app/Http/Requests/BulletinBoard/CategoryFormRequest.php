<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;


class CategoryFormRequest extends FormRequest
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
     *  rules()の前に実行される
     *       $this->merge(['key' => $value])を実行すると、
     *       フォームで送信された(key, value)の他に任意の(key, value)の組み合わせをrules()に渡せる
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
         // バリデーションルールをまとめる配列
         $rules = [];

         // $this->has()は$request->has()のこと
         // has()で指定した項目の有無を確認し、あればルールを追加
         if ($this->has('main_category_name')) {
             $rules['main_category_name'] = 'required|string|max:100|unique:main_categories,main_category';
         }
         if ($this->has('sub_category_name')) {
             $rules['sub_category_name'] = 'required|string|max:100|unique:sub_categories,sub_category';
             $rules['main_category_id'] = 'required|unique:sub_categories,main_category_id';
         }

         

         return $rules;


        // return [
        //     'main_category_name'=>'required|string|max:100|different:main_category_name',
        //     'main_category_id'=>'required',
        //     'sub_category_name' => 'required|string|max:100|different:sub_category_name'
        // ];
    }

    public function messages()
    {
        return [
            'required' => ':attributeは必ず入力してください。',
            'string' => ':attributeは文字列の型である必要があります。',
            'unique' => ':attributeは既に登録されています。',
            'min' => ':attributeは:min文字以上である必要があります。',
            'max' => ':attributeは:max文字以下である必要があります。',
            'different'=>'この:attributeはすでに登録済みです。'
        ];
    }
}
