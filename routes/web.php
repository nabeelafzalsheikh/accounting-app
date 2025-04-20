<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TrialBalanceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/sample', function () {
    return view('sample');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['admin'])->group(function () {

    Route::resource('transactions', TransactionController::class);
    Route::get('transactions/edit/{id}', [TransactionController::class, 'edit']);
    Route::get('/transactions/search', [TransactionController::class, 'search'])->name('transactions.search');

    Route::resource('accounts', AccountController::class)->only(['index', 'store', 'destroy']);
    Route::get('accounts/edit/{id}', [AccountController::class, 'edit']);

    Route::resource('account-types', AccountTypeController::class)->only(['index', 'store', 'destroy']);
    Route::get('account-types/edit/{id}', [AccountTypeController::class, 'edit']);

    Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
    Route::get('/ledger', [LedgerController::class, 'index'])->name('ledger.index');
    Route::get('/trial-balance', [TrialBalanceController::class, 'index'])->name('trial-balance.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index']);

});
