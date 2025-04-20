<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrialBalanceController extends Controller
{
    public function index(Request $request)
{
    $date = $request->input('date', Carbon::today()->format('Y-m-d'));

    $accounts = DB::table('accounts')
        ->leftJoin('transactions', function ($join) use ($date) {
            $join->on('accounts.id', '=', 'transactions.account_id')
                ->whereDate('transactions.date', '<=', $date);
        })
        ->leftJoin('account_types', 'accounts.type_id', '=', 'account_types.id')
        ->select(
            'accounts.id',
            'accounts.name',
            'accounts.type_id',
            'account_types.name as type_name', // ✅ Fetch account type name
            DB::raw('SUM(CASE WHEN transactions.type = "debit" THEN transactions.amount ELSE 0 END) as debit_balance'),
            DB::raw('SUM(CASE WHEN transactions.type = "credit" THEN transactions.amount ELSE 0 END) as credit_balance')
        )
        ->groupBy('accounts.id', 'accounts.name', 'accounts.type_id', 'account_types.name')
        ->orderBy('accounts.type_id')
        ->get();

    $totalDebit = $accounts->sum('debit_balance');
    $totalCredit = $accounts->sum('credit_balance');

    return view('trial-balance.index', [
        'accounts' => $accounts,
        'totalDebit' => $totalDebit,
        'totalCredit' => $totalCredit,
        'selectedDate' => $date
    ]);
}

}