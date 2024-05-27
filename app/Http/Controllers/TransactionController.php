<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
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

        return view("pages/transaction", compact("transactions"));
    }
    public function showDetail($id)
    {
        $transaction = Transaction::find($id);
        $transaction_detail = TransactionDetail::where('transaction_id', $id)->get();
        $product = Product::find($id);
        return view("pages/transaction_detail", compact("transaction", "transaction_detail", "product"));
    }
    public function edit($id)
    {
        $transaction = Transaction::find($id);
        return view("edit/edit-transaction", compact("transaction"));
    }
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        $transaction->status = $request->input('status');
        $transaction->save();
        return redirect()->route('transaction');
    }
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return redirect()->route('transaction');
    }
}
