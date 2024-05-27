<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showCart()
    {
        // Ambil semua item dalam keranjang belanja dari tabel carts
        $items = Cart::with('product')->where('user_id', auth()->id())->get();

        // Inisialisasi array untuk menyimpan detail produk
        $productsInCart = [];

        // Ambil detail produk dari keranjang belanja
        foreach ($items as $item) {
            // Tambahkan detail produk ke dalam array
            $productsInCart[] = [
                'id' => $item->id,
                'product' => $item->product,
                'quantity' => $item->quantity,
                'totalPrice' => $item->product->price * $item->quantity,
            ];
        }
        // Hitung total harga pembelian
        $totalPrice = array_sum(array_column($productsInCart, 'totalPrice'));

        // Tambahkan pesan jika keranjang belanja kosong
        $message = $items->isEmpty() ? 'Your cart is empty.' : '';
        return view('pages/cart', ['productsInCart' => $productsInCart, 'message' => $message]);
    }
    public function addToCart(Request $request, $id)
    {
        $product = Product::find($id);

        // Cek apakah produk sudah ada dalam keranjang belanja pengguna
        $existingCartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->first();

        // Jika produk sudah ada dalam keranjang belanja, tambahkan jumlahnya
        if ($existingCartItem) {
            $existingCartItem->quantity++;
            $existingCartItem->save();
        } else {
            // Jika produk belum ada dalam keranjang belanja, tambahkan sebagai item baru
            $cartItem = new Cart();
            $cartItem->user_id = auth()->id();
            $cartItem->product_id = $id;
            $cartItem->quantity = 1;
            $cartItem->save();
        }

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }
    public function editCartItem(Request $request, $id)
    {
        // Ambil item keranjang belanja
        $cartItem = Cart::find($id);

        // Periksa apakah item keranjang belanja ditemukan
        if (!$cartItem || $cartItem->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'Cart item not found.');
        }

        // Validasi input
        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);

        // Perbarui kuantitas item
        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Cart item updated successfully.');
    }
    public function deleteFromCart($id)
    {
        // Hapus item keranjang belanja berdasarkan ID
        $cartItem = Cart::find($id);

        // Periksa apakah item keranjang belanja ditemukan dan apakah milik user yang login
        if (!$cartItem || $cartItem->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'Cart item not found.');
        }

        // Hapus item keranjang belanja
        $cartItem->delete();

        return redirect()->back()->with('success', 'Product removed from cart successfully.');
    }
    public function redirectToCheckout(Request $request)
    {
        // Ambil cart_ids yang dikirim dari halaman cart
        $cartIds = $request->input('cart_ids');

        // Periksa jika $cartIds tidak ada atau kosong
        if (!$cartIds) {
            return redirect()->back()->with('error', 'No products selected for checkout.');
        }

        // Query untuk mendapatkan detail produk beserta quantity berdasarkan cart_ids
        $selectedProducts = Cart::with('product')
            ->whereIn('id', explode(',', $cartIds))
            ->where('user_id', auth()->id())
            ->get();

        // Redirect ke halaman checkout dengan membawa data produk
        return view('pages.checkout', [
            'products' => $selectedProducts,
            'totalPrice' => $request->input('total_price'),
        ]);
    }
}
