<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // SaleモデルがProductモデルとリレーション関係を結ぶためのメソッド
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected $fillable = [
        'product_id',
    ];
}
