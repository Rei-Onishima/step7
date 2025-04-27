<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    //　一括代入可能な属性
    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'company_id',
        'comment',
        'img_path',
    ];

    // Productモデルがsalesテーブルとリレーション関係を結ぶためのメソッド
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Productモデルがcompanysテーブルとリレーション関係を結ぶ為のメソッド
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    //商品作成
    public static function createProduct($data)
    {
        return self::create($data);
    }

    //商品更新
    public function updateProduct($data)
    {
        $this->update($data);
    }

    //画像のアップロード　
    public static function handleImageUpload($request)
    {
        if ($request->hasFile('img_path')) { 
            $original = $request->img_path->getClientOriginalName();
            $fileName = date('YmdHis') . '_' . $original;
            $filePath = $request->img_path->storeAs('products', $fileName, 'public');
            return '/storage/' . $filePath;
        }

        return null;
    }
}
