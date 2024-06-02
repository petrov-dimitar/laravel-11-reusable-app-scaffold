<?php
namespace App\Http\Controllers;

use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Get all transactions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllTransactions()
    {
        // Retrieve all transactions
        $transactions = Transaction::all();

        // Return the transactions as a JSON response
        return response()->json($transactions);
    }
}
