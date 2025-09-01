<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('storeメソッドに到達しました');

        // バリデーション（例外処理付き）
        try {
            $validated = $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('バリデーション失敗: ' . json_encode($e->errors()));
            return response()->json([
                'status' => 'error',
                'message' => 'バリデーションエラー',
                'errors' => $e->errors()
            ], 422);
        }

        $product = Product::find($validated['product_id']);
        $quantity = $validated['quantity'];

        if ($product->stock < $quantity) {
            return response()->json([
                'status' => 'error',
                'message' => '在庫不足です'
            ], 400);
        }

        try {
            DB::transaction(function () use ($product, $quantity) {
                \Log::info('Sale作成前');

                Sale::create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);

                \Log::info('在庫減算前');

                $product->decrement('stock', $quantity);

                \Log::info('トランザクション終了');
            });

            \Log::info('購入完了レスポンス直前');

            return response()->json([
                'status' => 'success',
                'message' => '購入完了'
            ]);
        } catch (\Exception $e) {
            \Log::error('購入処理失敗: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
