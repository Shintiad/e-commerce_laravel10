<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function show()
    {
        $user = Auth::user();

        // Jika pengguna adalah admin, ambil semua transaksi
        if ($user->role == 1) {
            $transactions = Transaction::all();
        } else {
            // Jika bukan admin, ambil hanya transaksi milik pengguna tersebut
            $transactions = Transaction::where('user_id', $user->id)->get();
        }

        return response()->json(['transactions' => $transactions]);
    }

    public function showDetail($id)
    {
        // Cari transaksi berdasarkan ID, termasuk detailnya
        $transaction = Transaction::with('details.product')->find($id);

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // Siapkan data detail transaksi
        $transaction_details = $transaction->details->map(function ($detail) {
            return [
                'transaction_id' => $detail->transaction_id,
                'product_name' => $detail->product->product_name, // Ensure this line fetches the correct product name
                'quantity' => $detail->quantity,
                'price' => $detail->price,
            ];
        });

        return response()->json(['transaction_details' => $transaction_details]);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->input('status');
        $transaction->save();

        return response()->json(['message' => 'Transaction updated successfully']);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully']);
    }
}
