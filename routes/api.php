<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AccountTypeController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\TransactionController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Account Types Routes
Route::get('account-types', [AccountTypeController::class, 'index']);
Route::post('account-types', [AccountTypeController::class, 'store']);
Route::get('account-types/{accountType}', [AccountTypeController::class, 'show']);
Route::put('account-types/{accountType}', [AccountTypeController::class, 'update']);
Route::delete('account-types/{accountType}', [AccountTypeController::class, 'destroy']);

// Accounts Routes
Route::get('accounts', [AccountController::class, 'index']);
Route::post('accounts', [AccountController::class, 'store']);
Route::get('accounts/{account}', [AccountController::class, 'show']);
Route::put('accounts/{account}', [AccountController::class, 'update']);
Route::delete('accounts/{account}', [AccountController::class, 'destroy']);

// Transactions Routes
Route::get('transactions', [TransactionController::class, 'index']);
Route::post('transactions', [TransactionController::class, 'store']);
Route::get('transactions/{transaction}', [TransactionController::class, 'show']);
Route::put('transactions/{transaction}', [TransactionController::class, 'update']);
Route::delete('transactions/{transaction}', [TransactionController::class, 'destroy']);

// Dashboard Summary
Route::get('dashboard/summary', function() {
    $totalIncome = \App\Models\Transaction::where('type', 'credit')->sum('amount');
    $totalExpenses = \App\Models\Transaction::where('type', 'debit')->sum('amount');
    $netProfit = $totalIncome - $totalExpenses;
    $unpaidInvoices = 0; // You would implement your own logic for this

    return response()->json([
        'total_income' => $totalIncome,
        'total_expenses' => $totalExpenses,
        'net_profit' => $netProfit,
        'unpaid_invoices' => $unpaidInvoices
    ]);
});