<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    
    public function getList() {
        // productsテーブルからデータを取得
        $products = DB::table('products')->get();

        return $products;
    }

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
}
