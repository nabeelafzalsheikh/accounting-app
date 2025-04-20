<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LedgerController extends Controller
{
    public function index(Request $request)
    {
        // Get parameters from request or use defaults
        $accountId = $request->input('account_id');
        $startDate = $request->input('start_date', Carbon::today()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));

        // Get all accounts for dropdown
        $accounts = DB::table('accounts')->orderBy('name')->get();

        // Base query for ledger entries
        $query = DB::table('transactions')
            ->join('accounts', 'transactions.account_id', '=', 'accounts.id')
            ->select(
                'transactions.id',
                'transactions.date',
                'accounts.name as account_name',
                'transactions.type',
                'transactions.amount',
                'transactions.description',
                'transactions.transaction_group_id'
            )
            ->whereBetween('transactions.date', [$startDate, $endDate])
            ->orderBy('transactions.date')
            ->orderBy('transactions.id');

        // Filter by account if selected
        if ($accountId) {
            $query->where('transactions.account_id', $accountId);
        }

        $transactions = $query->get();

        // Calculate running balances
        $runningBalance = 0;
        $ledgerEntries = [];
        foreach ($transactions as $transaction) {
            if ($transaction->type === 'debit') {
                $runningBalance += $transaction->amount;
            } else {
                $runningBalance -= $transaction->amount;
            }

            $ledgerEntries[] = (object) [
                'date' => $transaction->date,
                'account_name' => $transaction->account_name,
                'type' => $transaction->type,
                'amount' => $transaction->amount,
                'description' => $transaction->description,
                'transaction_group_id' => $transaction->transaction_group_id,
                'balance' => $runningBalance
            ];
        }

        return view('ledger.index', [
            'ledgerEntries' => $ledgerEntries,
            'accounts' => $accounts,
            'selectedAccount' => $accountId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentBalance' => $runningBalance
        ]);
    }
}