@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">
                <i class="fas fa-exchange-alt text-primary mr-2"></i> Transactions
            </h2>
            <a href="{{ route('transactions.create') }}" class="btn btn-success">
                <i class="fas fa-plus mr-1"></i> Create Transaction
            </a>
        </div>
    </div>
    
    <!-- Date Filter Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('journal.index') }}" class="form-inline">
                <div class="form-group mr-3">
                    <label for="date" class="mr-2">Filter by Date:</label>
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
                <a href="{{ route('journal.index') }}" class="btn btn-secondary">
                    <i class="fas fa-sync-alt mr-1"></i> Reset
                </a>
            </form>
        </div>
    </div>
    
    <!-- Transactions Card -->
    <div class="card mb-4">
        <div class="card-body">
            @if($transactionGroups->isEmpty())
                <div class="alert alert-info">
                    No transactions found for {{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}.
                </div>
            @else
                <div class="alert alert-success mb-4">
                    Showing transactions for {{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
                </div>
                
                @foreach($transactionGroups as $groupId => $transactions)
                <div class="transaction-group mb-4">
                    <h5>Transaction #{{ $groupId }}</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Account</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($transaction->date)->format('m/d/Y') }}</td>
                                <td>{{ $transaction->account_name }}</td>
                                <td class="text-right">{{ $transaction->type === 'debit' ? number_format($transaction->amount, 2) : '' }}</td>
                                <td class="text-right">{{ $transaction->type === 'credit' ? number_format($transaction->amount, 2) : '' }}</td>
                                <td>{{ $transaction->description }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection