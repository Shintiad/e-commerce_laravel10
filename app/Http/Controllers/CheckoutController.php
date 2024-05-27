<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'deliver_address' => 'required|string|max:255',
            'total_price' => 'required|numeric|min:0',
            'cart_ids' => 'required|array',
            'cart_ids.*' => 'exists:carts,id,user_id,' . $user->id,
        ]);

        // Memulai transaksi database
        DB::beginTransaction();

        try {
            // Simpan transaksi ke dalam tabel transactions
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->full_name = $validatedData['full_name'];
            $transaction->deliver_address = $validatedData['deliver_address'];
            $transaction->total_price = $validatedData['total_price'];
            $transaction->transaction_date = now(); // Tanggal checkout
            $transaction->status = 'proses'; // Misalnya status di-set menjadi 'proses'
            $transaction->save();

            // Simpan detail produk yang dibeli dalam tabel transaction_details
            foreach ($validatedData['cart_ids'] as $cartId) {
                $cartItem = Cart::findOrFail($cartId);
                $product = $cartItem->product;
                $quantity = $cartItem->quantity;

                // Validasi stok cukup sebelum melakukan pembelian
                if ($quantity > $product->stock) {
                    DB::rollBack(); // Batalkan transaksi jika stok tidak mencukupi
                    return redirect()->back()->with('error', 'The quantity of ' . $product->product_name . ' is not enough in stock.');
                }

                // Simpan detail transaksi
                $transactionDetail = new TransactionDetail();
                $transactionDetail->transaction_id = $transaction->id;
                $transactionDetail->product_id = $product->id;
                $transactionDetail->quantity = $quantity;
                $transactionDetail->price = $product->price;
                $transactionDetail->save();

                // Kurangi stok produk setelah detail transaksi disimpan
                $product->stock -= $quantity;
                $product->save();

                // Hapus produk dari keranjang belanja (cart)
                $cartItem->delete();
            }

            // Commit transaksi database
            DB::commit();

            return redirect()->route('transaction')->with('success', 'Checkout successful.'); // Redirect ke halaman sukses checkout
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi error
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to process checkout. Please try again.');
        }
    }
}
