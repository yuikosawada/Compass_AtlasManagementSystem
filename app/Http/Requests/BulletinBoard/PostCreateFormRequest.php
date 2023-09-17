<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;


class PostCreateFormRequest extends FormRequest
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
        // dd($this->input('post_title'));

        return [
            // 投稿用
            'post_title' => 'required|min:4|max:50',
            'post_body' => 'required|min:10|max:500',
           
        ];
    }

    public function messages()
    {
        return [
            'post_title.min' => 'タイトルは4文字以上入力してください。',
            'post_title.max' => 'タイトルは50文字以内で入力してください。',
            'post_body.min' => '内容は10文字以上入力してください。',
            'post_body.max' => '最大文字数は500文字です。',
            


            'required' => ':attributeは必ず入力してください。',
            'string' => ':attributeは文字列の型である必要があります。',
            'email' => ':attributeは有効なメールアドレスである必要があります。',
            'unique' => ':attributeは既に登録されています。',
            'katakana' => ':attributeはカタカナのみである必要があります。',
            'date' => ':attributeは正しい日付である必要があります。',
            'in' => ':attributeは:valuesのいずれかである必要があります。',
            'min' => ':attributeは:min文字以上である必要があります。',
            'max' => ':attributeは:max文字以下である必要があります。',
            'same' => ':attributeと:otherは同じである必要があります。',
            'integer' => ':attributeは整数を入力して下さい',
            'valid_date_range' => '2000年以前、もしくは日付が有効でない為、登録出来ません。'

        ];
    }
}
