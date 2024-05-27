<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;

class CheckoutApiController extends Controller
{
    public function processCheckout(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'deliver_address' => 'required|string|max:255',
            'total_price' => 'required|numeric',
            'cart_items' => 'required|array',
            'cart_items.*.product_id' => 'required|exists:products,id',
            'cart_items.*.quantity' => 'required|integer|min:1',
            'cart_items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($validatedData, $user) {
                // Simpan transaksi ke dalam tabel transactions
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'full_name' => $validatedData['full_name'],
                    'deliver_address' => $validatedData['deliver_address'],
                    'total_price' => $validatedData['total_price'],
                    'transaction_date' => now(),
                    'status' => 'proses',
                ]);

                // Simpan detail produk yang dibeli dalam tabel transaction_details
                foreach ($validatedData['cart_items'] as $item) {
                    $product = Product::findOrFail($item['product_id']);

                    // Validasi stok cukup sebelum melakukan pembelian
                    if ($item['quantity'] > $product->stock) {
                        throw new \Exception('The quantity of ' . $product->product_name . ' is not enough in stock.');
                    }

                    // Simpan detail transaksi
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);

                    // Kurangi stok produk setelah detail transaksi disimpan
                    $product->decrement('stock', $item['quantity']);

                    // Hapus item dari keranjang setelah checkout
                    Cart::where('user_id', $user->id)
                        ->where('product_id', $item['product_id'])
                        ->delete();
                }
            });

            return response()->json(['message' => 'Checkout successful'], 200);
        } catch (\Exception $e) {
            // Log the exact error message for debugging
            Log::error('Checkout process failed: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to process checkout. Please try again. Error: ' . $e->getMessage()], 500);
        }
    }
}
