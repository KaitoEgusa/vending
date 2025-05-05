<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vending;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        DB::beginTransaction();
        try {
            $product = Vending::findOrFail($request->product_id);

            if ($product->stock <= 0) {
                return response()->json(['message' => '在庫がありません。'], 400);
            }

            // salesテーブルに追加
            Sale::create([
                'product_id' => $product->id,
            ]);

            //在庫を減らす
            $product->decrement('stock');

            DB::commit();

            return response()->json(['message' => '購入完了しました']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => '購入処理に失敗しました', 'error' => $e->getMessage()], 500);
        }
    }
}
