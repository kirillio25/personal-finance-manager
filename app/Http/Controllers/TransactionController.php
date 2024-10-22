<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // public function index(Request $request)
    // {
    //     // Фильтр по дате
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');

    //     $query = Transaction::query();

    //     if ($startDate && $endDate) {
    //         $query->whereBetween('transaction_date', [$startDate, $endDate]);
    //     }

    //     $transactions = $query->get();

    //     // Подсчет расходов и доходов
    //     $totalIncome = $transactions->where('category', 'доход')->sum('amount');
    //     $totalExpense = $transactions->where('category', 'расход')->sum('amount');

    //     return response()->json([
    //         'transactions' => $transactions,
    //         'totalIncome' => $totalIncome,
    //         'totalExpense' => $totalExpense,
    //     ]);
    // }

    public function index()
    {
        $transactions = Transaction::all(); // Получаем все транзакции
        return response()->json([
            'transactions' => $transactions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        Transaction::create($request->all());

        return response()->json(['message' => 'Transaction added successfully']);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $transaction->update($request->all());

        return response()->json(['message' => 'Transaction updated successfully']);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully']);
    }
}

