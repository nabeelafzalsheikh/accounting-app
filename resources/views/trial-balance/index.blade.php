<!-- resources/views/trial-balance/index.blade.php -->
@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">
                <i class="fas fa-scale-balanced text-primary mr-2"><i class="fas fa-balance-scale"></i></i> Trial Balance
            </h2>
        </div>
    </div>

    <!-- Date Filter Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('trial-balance.index') }}" class="form-inline">
                <div class="form-group mr-3">
                    <label for="date" class="mr-2">As of Date:</label>
                    <input type="date" 
                           class="form-control" 
                           id="date" 
                           name="date" 
                           value="{{ $selectedDate }}"
                           max="{{ now()->format('Y-m-d') }}">
                </div>
                <button type="submit" class="btn btn-primary mr-2">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <a href="{{ route('trial-balance.index') }}" class="btn btn-secondary">
                    <i class="fas fa-sync-alt mr-1"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Trial Balance Card -->
    <div class="card">
        <div class="card-body">
            <div class="alert alert-info mb-4">
                Showing trial balance as of {{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Account Type</th>
                            <th>Account Name</th>
                            <th class="text-right">Debit ({{ config('currency.symbol') }})</th>
                            <th class="text-right">Credit ({{ config('currency.symbol') }})</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                        <tr>
                            <td>{{ $account->type_name }}</td>
                            <td>{{ $account->name }}</td>
                            <td class="text-right">{{ number_format($account->debit_balance, 2) }}</td>
                            <td class="text-right">{{ number_format($account->credit_balance, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-active">
                        <tr>
                            <td colspan="2" class="text-right font-weight-bold">Total</td>
                            <td class="text-right font-weight-bold">{{ number_format($totalDebit, 2) }}</td>
                            <td class="text-right font-weight-bold">{{ number_format($totalCredit, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-center {{ $totalDebit == $totalCredit ? 'text-success' : 'text-danger' }}">
                                <strong>
                                    @if($totalDebit == $totalCredit)
                                        <i class="fas fa-check-circle mr-1"></i> Trial Balance Matches
                                    @else
                                        <i class="fas fa-exclamation-circle mr-1"></i> Trial Balance Does Not Match (Difference: {{ number_format(abs($totalDebit - $totalCredit), 2) }})
                                    @endif
                                </strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection