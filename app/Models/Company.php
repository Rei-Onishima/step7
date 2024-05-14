<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // Companyモデルがproductsテーブルとリレーション関係を結ぶ為のメソッド
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
