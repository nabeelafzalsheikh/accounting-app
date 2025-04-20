<?php
namespace App\Http\Controllers;

use App\Models\AccountType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AccountTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AccountType::latest();
            
            return DataTables::of($data)
                ->addColumn('action', function($row) {
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-primary btn-sm edit">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm delete">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('account_types.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:account_types,name',
            'slug' => 'required|string|max:255|unique:account_types,slug'
        ]);

        AccountType::updateOrCreate(
            ['id' => $request->id],
            $request->except('_token')
        );

        return response()->json(['success' => 'Account type saved successfully.']);
    }

    public function edit($id)
    {
        $accountType = AccountType::find($id);
        return response()->json($accountType);
    }

    public function destroy($id)
    {
        AccountType::find($id)->delete();
        return response()->json(['success' => 'Account type deleted successfully.']);
    }
}