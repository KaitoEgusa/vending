<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest { public function authorize(): bool
    { return true;
    }

    public function rules(): array { return [
            'title'     => 'required|string|max:255',
            'maker'     => 'required|exists:companies,id',
            'price'     => 'required|integer|min:0',
            'stock'     => 'required|integer|min:0',
            'comment'   => 'nullable|string|max:1000',
            'image'     => 'nullable' ,
        ];
    }

    public function messages(): array { return [
            'title.required'     => '商品名は必須です。',
            'title.max'          => '商品名は255文字以内で入力してください。',
            'maker.required'     => 'メーカーを選択してください。',
            'maker.exists'       => '選択されたメーカーが存在しません。',
            'price.required'     => '価格は必須です。',
            'price.integer'      => '価格は整数で入力してください。',
            'price.min'          => '価格は0以上で入力してください。',
            'stock.required'     => '在庫数は必須です。',
            'stock.integer'      => '在庫数は整数で入力してください。',
            'stock.min'          => '在庫数は0以上で入力してください。',
            'comment.max'        => 'コメントは1000文字以内で入力してください。',
        ];
    }
}