<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TransactionStoreRequest;
use Illuminate\Support\Facades\Log;
class TransactionController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        $data = Transaction::with(['account', 'group'])->latest();
        
        return DataTables::of($data)
            ->addColumn('account_name', function($row) {
                return $row->account->name ?? 'N/A';
            })
            ->addColumn('group_description', function($row) {
                return $row->group ? $row->group->id : 'N/A';
            })
            ->addColumn('amount_formatted', function($row) {
                return number_format($row->amount, 2);
            })
            ->addColumn('type_badge', function($row) {
                $class = $row->type == 'credit' ? 'success' : 'danger';
                return '<span class="badge bg-'.$class.'">'.ucfirst($row->type).'</span>';
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('transactions.edit', $row->id).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm delete">Delete</a>';
                return $btn;
            })
            ->rawColumns(['type_badge', 'action'])
            ->make(true);
    }

       return view('transactions.index'); // Add transactions to compact
}


public function search(Request $request)
{
    $perPage = 10;
    $page = $request->get('page', 1);
    
    $query = Transaction::query()
        ->select('id', 'description', 'amount', 'type')
        ->when($request->search, function($q) use ($request) {
            $q->where('description', 'like', '%'.$request->search.'%')
              ->orWhere('id', 'like', '%'.$request->search.'%');
        });
    
    $total = $query->count();
    $results = $query->skip(($page - 1) * $perPage)
                    ->take($perPage + 1) // Get one more to check if there are more pages
                    ->get();
    
    $hasMore = $results->count() > $perPage;
    if ($hasMore) {
        $results = $results->slice(0, $perPage);
    }
    
    return response()->json([
        'results' => $results->map(function($item) {
            return [
                'id' => $item->id,
                'text' => "#{$item->id} - {$item->description}",
                'description' => $item->description,
                'amount' => $item->amount,
                'type' => $item->type
            ];
        }),
        'pagination' => [
            'more' => $hasMore
        ]
    ]);
}


//   create function for transaction
public function create()
{
    $accounts = Account::with('type')->get();
    $transactions = Transaction::whereMonth('created_at', Carbon::now()->month)
    ->whereYear('created_at', Carbon::now()->year)
    ->orderBy('created_at', 'desc')
    ->get(); // Add this line
    return view('transactions.create', compact('accounts', 'transactions'));
}


public function store(TransactionStoreRequest $request)
{
    $validated = $request->validated();

    $transaction = Transaction::create($validated);

    return redirect()->route('transactions.index')
                     ->with('success', 'Transaction created successfully!');
}

public function edit($id)
{
    $transaction = Transaction::findOrFail($id);
    $accounts = Account::with('type')->get(); // or whatever you need
    $transactions = Transaction::all(); // exclude current transaction
    
    return view('transactions.edit', compact('transaction', 'accounts', 'transactions'));
}

public function update(Request $request, $id)
{
    // Validate the request data
    $validated = $request->validate([
        'account_id' => 'required|exists:accounts,id',
        'transaction_group_id' => 'nullable|exists:transactions,id',
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'type' => 'required|in:debit,credit',
        'date' => 'required|date',
    ]);

    try {
        // Find the transaction to update
        $transaction = Transaction::findOrFail($id);

        // Update the transaction
        $transaction->update([
            'account_id' => $validated['account_id'],
            'transaction_group_id' => $validated['transaction_group_id'],
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'date' => $validated['date'],
        ]);

        // Redirect with success message
        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully!');

    } catch (\Exception $e) {
        // Log the error
        Log::error('Error updating transaction: ' . $e->getMessage());

        // Redirect back with error message
        return back()->withInput()
            ->with('error', 'Error updating transaction. Please try again.');
    }
}

    public function destroy($id)
    {
        Transaction::find($id)->delete();
        return response()->json(['success' => 'Transaction deleted successfully.']);
    }
}