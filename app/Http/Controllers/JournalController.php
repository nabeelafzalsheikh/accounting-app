<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        // Get date from request or use today's date
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        
        // Get transactions for the selected date
        $transactionGroups = DB::table('transactions')
            ->join('accounts', 'transactions.account_id', '=', 'accounts.id')
            ->select('transactions.*', 'accounts.name as account_name')
            ->whereDate('transactions.date', $date)
            ->orderBy('transaction_group_id')
            ->orderBy('type', 'desc') // debits first
            ->get()
            ->groupBy('transaction_group_id');

        return view('journal.index', [
            'transactionGroups' => $transactionGroups,
            'selectedDate' => $date
        ]);
    }
}