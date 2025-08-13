<?php

return [
    'required' => ':attributeは必須項目です。',
    'unique' => ':attributeはすでに使用されています。',
    'confirmed' => ':attributeが確認用と一致しません。',
    'min' => [
        'string' => ':attributeは:min文字以上で入力してください。',
    ],

    'attributes' => [
        // 商品関連
        'company_id' => 'メーカー名',
        'product_name' => '商品名',
        'price' => '価格',
        'stock' => '在庫数',
        'comment' => 'コメント',
        'img_path' => '商品画像',

        // ユーザー関連
        'name' => '名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード（確認）',
    ],
];
