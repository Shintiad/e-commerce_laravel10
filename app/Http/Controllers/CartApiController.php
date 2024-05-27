<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CartApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function showCart()
    {
        try {
            $user_id = Auth::id();
            $items = Cart::with('product')->where('user_id', $user_id)->get();

            $productsInCart = $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product->id,
                    'product_name' => $item->product->product_name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'totalPrice' => $item->product->price * $item->quantity,
                ];
            });

            $totalPrice = $productsInCart->sum('totalPrice');
            $message = $items->isEmpty() ? 'Your cart is empty.' : '';

            $data = [
                'productsInCart' => $productsInCart,
                'message' => $message,
                'totalPrice' => $totalPrice,
            ];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch cart data.'], 500);
        }
    }

    public function addToCart(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            // Begin database transaction
            DB::beginTransaction();

            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                $cartItem = new Cart();
                $cartItem->user_id = Auth::id();
                $cartItem->product_id = $product->id;
                $cartItem->quantity = 1;
                $cartItem->save();
            }

            // Commit transaction if all queries succeed
            DB::commit();

            $responseData = [
                'success' => true,
                'message' => 'Product added to cart successfully.',
                'cart_item' => [
                    'id' => $cartItem->id,
                    'user_id' => $cartItem->user_id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                ],
            ];

            return response()->json($responseData);
        } catch (\Exception $e) {
            // Rollback transaction if there's an error
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart.',
                'error' => $e->getMessage(),
            ], 400); // 400 untuk kesalahan input atau permintaan
        }
    }

    public function editCartItem(Request $request, $id)
    {
        try {
            $cartItem = Cart::findOrFail($id);

            if ($cartItem->user_id != Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found.',
                ], 404);
            }

            $validatedData = $request->validate([
                'quantity' => 'required|numeric|min:1',
            ]);

            $cartItem->update(['quantity' => $validatedData['quantity']]);

            return response()->json([
                'success' => true,
                'message' => 'Cart item updated successfully.',
                'cart_item' => [
                    'id' => $cartItem->id,
                    'product_id' => $cartItem->product->id,
                    'product_name' => $cartItem->product->product_name,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'totalPrice' => $cartItem->product->price * $cartItem->quantity,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart item.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function deleteFromCart($id)
    {
        try {
            $cartItem = Cart::findOrFail($id);

            if ($cartItem->user_id != Auth::id()) {
                return Response::json([
                    'success' => false,
                    'message' => 'Cart item not found.',
                ], 404);
            }

            $cartItem->delete();

            return Response::json([
                'success' => true,
                'message' => 'Product removed from cart successfully.',
            ]);
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Failed to remove product from cart.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
