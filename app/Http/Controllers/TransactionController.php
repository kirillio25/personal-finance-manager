<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json(['transactions' => $transactions]);
    }

    public function store(Request $request)
    {
        $transaction = Transaction::create($request->all());
        return response()->json(['transaction' => $transaction]);
    }

    public function destroy($id)
    {
        Transaction::destroy($id);
        return response()->json(['message' => 'Транзакция удалена']);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());

        return response()->json(['transaction' => $transaction]);
    }

}

