<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

class SalesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->product_id);

        if ($product->stock <= 0) {
            return response()->json([
                'message' => '在庫がありません。',
            ], 400);
        }

        // salesテーブルにレコード追加
        Sale::create([
            'product_id' => $product->id,
        ]);

        // productsテーブルの在庫を減らす
        $product->decrement('stock');

        return response()->json([
            'message' => '購入が完了しました。',
        ], 200);
    }
}

