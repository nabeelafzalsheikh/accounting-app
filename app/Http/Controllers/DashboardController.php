<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get all accounts with their transactions and type
        $accounts = Account::with(['transactions', 'type'])->get();

        // Calculate balances for each account type
        $cashBalance = DB::table('accounts')
            ->join('transactions', 'accounts.id', '=', 'transactions.account_id')
            ->where('accounts.id', 1)
            ->selectRaw('SUM(CASE WHEN transactions.type = "debit" THEN transactions.amount ELSE -transactions.amount END) as balance')
            ->value('balance') ?? 0;

        $receivableBalance = DB::table('accounts')
            ->join('transactions', 'accounts.id', '=', 'transactions.account_id')
            ->where('accounts.id', 2)
            ->selectRaw('SUM(CASE WHEN transactions.type = "debit" THEN transactions.amount ELSE -transactions.amount END) as balance')
            ->value('balance') ?? 0;

        $inventoryValue = DB::table('accounts')
            ->join('transactions', 'accounts.id', '=', 'transactions.account_id')
            ->where('accounts.id', 3)
            ->selectRaw('SUM(CASE WHEN transactions.type = "debit" THEN transactions.amount ELSE -transactions.amount END) as balance')
            ->value('balance') ?? 0;

        $ownersEquity = DB::table('accounts')
            ->join('transactions', 'accounts.id', '=', 'transactions.account_id')
            ->where('accounts.id', 10)
            ->selectRaw('SUM(CASE WHEN transactions.type = "credit" THEN transactions.amount ELSE -transactions.amount END) as balance')
            ->value('balance') ?? 0;

        // Prepare account balances for display
        $accountBalances = $accounts->map(function ($account) {
            $balance = $account->transactions->sum(function ($transaction) {
                return $transaction->type === 'debit' ? $transaction->amount : -$transaction->amount;
            });

            return [
                'id' => $account->id,
                'name' => $account->name,
                'type' => $account->type->name,
                'balance' => $balance,
                'color' => $account->color
            ];
        });

        // Get recent transactions
        $recentTransactions = Transaction::with('account')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'cashBalance',
            'receivableBalance',
            'inventoryValue',
            'ownersEquity',
            'accountBalances',
            'recentTransactions'
        ));
    }
}