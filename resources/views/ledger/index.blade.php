@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">
                <i class="fas fa-book text-primary mr-2"></i> General Ledger
            </h2>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('ledger.index') }}" class="form">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="account_id">Account</label>
                            <select class="form-control" id="account_id" name="account_id">
                                <option value="">All Accounts</option>
                                @foreach($accounts as $account)
                                <option value="{{ $account->id }}" {{ $selectedAccount == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">From Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ $startDate }}" max="{{ now()->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">To Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="{{ $endDate }}" max="{{ now()->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Ledger Card -->
    <div class="card">
        <div class="card-body">
            @if(count($ledgerEntries) > 0)
                <div class="alert alert-info mb-4">
                    Showing entries from {{ \Carbon\Carbon::parse($startDate)->format('M j, Y') }} 
                    to {{ \Carbon\Carbon::parse($endDate)->format('M j, Y') }}
                    @if($selectedAccount)
                        for {{ $accounts->firstWhere('id', $selectedAccount)->name }}
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Account</th>
                                <th>Description</th>
                                <th class="text-right">Debit</th>
                                <th class="text-right">Credit</th>
                                <th class="text-right">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ledgerEntries as $entry)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($entry->date)->format('m/d/Y') }}</td>
                                <td>{{ $entry->account_name }}</td>
                                <td>{{ $entry->description }}</td>
                                <td class="text-right">{{ $entry->type === 'debit' ? number_format($entry->amount, 2) : '' }}</td>
                                <td class="text-right">{{ $entry->type === 'credit' ? number_format($entry->amount, 2) : '' }}</td>
                                <td class="text-right font-weight-bold">{{ number_format($entry->balance, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <td colspan="5" class="text-right font-weight-bold">Ending Balance</td>
                                <td class="text-right font-weight-bold">{{ number_format($currentBalance, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="alert alert-warning">
                    No ledger entries found for the selected criteria.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection