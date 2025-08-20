<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'company_id' => 'required|exists:companies,id',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|max:2048',
        ];
    }

    public function messages()
{
    return [
        'company_id.required' => 'メーカー名は必須項目です。',
        'product_name.required' => '商品名は必須項目です。',
        'price.required' => '価格は必須項目です。',
        'price.numeric' => '価格は数値で入力してください。',
        'stock.required' => '在庫数は必須項目です。',
        'stock.integer' => '在庫数は整数で入力してください。',
        'img_path.required' => '商品画像は必須項目です。',
        // 必要に応じて追加
    ];
}

public function attributes()
{
    return [
        'company_id' => 'メーカー名',
        'product_name' => '商品名',
        'price' => '価格',
        'stock' => '在庫数',
        'comment' => 'コメント',
        'img_path' => '商品画像',
    ];
}

}
