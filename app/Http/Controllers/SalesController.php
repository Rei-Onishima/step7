<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function store(Request $request)
    {
        //product_id の存在だけチェック（exists は使わない）
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            //該当商品を取得
            $product = Product::find($request->product_id);

            //商品が見つからなかった場合
            if (!$product) {
                return response()->json([
                    'message' => '該当商品が見つかりません。'
                ], 404);
            }

            //在庫がない場合
            if ($product->stock <= 0) {
                return response()->json([
                    'message' => '在庫がありません。',
                ], 400);
            }

            //売上を記録
            Sale::create([
                'product_id' => $product->id,
            ]);

            //在庫を1減らす
            $product->decrement('stock');

            DB::commit();

            return response()->json([
                'message' => '購入が完了しました。',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => '処理中にエラーが発生しました。',
                'error' => $e->getMessage(), // デバッグ用（本番では消す）
            ], 500);
        }
    }
}

