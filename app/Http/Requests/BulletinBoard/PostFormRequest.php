<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
            'post_title' => 'min:4|max:50',
            'post_body' => 'min:10|max:500',

            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|katakana|max:30',
            'under_name_kana' => 'required|string|katakana|max:30',
            'mail_address' => 'required|email|unique:users|max:100',
            'sex' => 'required|in:男性,女性,その他',
            'old_year' => 'required|date|before:today',
            'old_month' => 'required|integer|between:1,12',
            'old_day' => 'required|integer|between:1,31',
            'role' => 'required|in:講師(国語),講師(数学),教師(英語),生徒',
            'password' => 'required|min:8|max:30|same:password_confirmation',

        ];
    }

    public function messages()
    {
        return [
            'post_title.min' => 'タイトルは4文字以上入力してください。',
            'post_title.max' => 'タイトルは50文字以内で入力してください。',
            'post_body.min' => '内容は10文字以上入力してください。',
            'post_body.max' => '最大文字数は500文字です。',

            'required' => ':attributeは必須項目です。',
            'string' => ':attributeは文字列の型である必要があります。',
            'max' => ':attributeは:max文字以下である必要があります。',
            'email' => ':attributeは有効なメールアドレスである必要があります。',
            'unique' => ':attributeは既に登録されています。',
            'katakana' => ':attributeはカタカナのみである必要があります。',
            'date' => ':attributeは正しい日付である必要があります。',
            'in' => ':attributeは:valuesのいずれかである必要があります。',
            'min' => ':attributeは:min文字以上である必要があります。',
            'max' => ':attributeは:max文字以下である必要があります。',
            'same' => ':attributeと:otherは同じである必要があります。',
        ];
    }
}
