<?php
namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Account::with('type')->latest();
            
            return DataTables::of($data)
                ->addColumn('type_name', function($row) {
                    return $row->type->name;
                })
                ->addColumn('balance', function($row) {
                    return number_format($row->balance, 2);
                })
                ->addColumn('color_display', function($row) {
                    return '<span class="badge" style="background-color: '.$row->color.'">&nbsp;&nbsp;&nbsp;</span>';
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-primary btn-sm edit">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm delete">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['color_display', 'action'])
                ->make(true);
        }

        $accountTypes = AccountType::all();
        return view('accounts.index', compact('accountTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:account_types,id',
            'color' => 'required|string|max:7'
        ]);

        Account::updateOrCreate(
            ['id' => $request->id],
            $request->except('_token')
        );

        return response()->json(['success' => 'Account saved successfully.']);
    }

    public function edit($id)
    {
        $account = Account::find($id);
        return response()->json($account);
    }

    public function destroy($id)
    {
        Account::find($id)->delete();
        return response()->json(['success' => 'Account deleted successfully.']);
    }
}