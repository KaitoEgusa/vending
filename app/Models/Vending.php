<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vending extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'company_id',
        'price',
        'stock',
        'comment',
        'img_path'
    ];

    public $timestamps = false;

    // アクセサ（ビューから title, maker, image として使えるようにする）
    public function getTitleAttribute()
    {
        return $this->product_name;
    }

    public function getMakerAttribute()
    {
        return optional($this->company)->company_name;
    }

    public function getImageAttribute()
    {
        return $this->img_path;
    }

    // リレーション：products → companies
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // 商品登録
    public function newregist($request, $image_path = null)
    {
        DB::table('products')->insert([
            'product_name' => $request->title,
            'company_id' => $request->maker,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $image_path
        ]);
    }

    public function regist($image_path)
    {
        DB::table('products')->insert([
            'img_path' => $image_path
        ]);
    }
}