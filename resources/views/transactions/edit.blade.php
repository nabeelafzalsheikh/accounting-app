@extends('layouts.app2')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h2 class="h4 mb-0">
            <i class="fas fa-edit text-success mr-2"></i> Edit Transaction
        </h2>
        
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Transactions
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
            @csrf
            @method('PUT')

            <div class="container-fluid">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="account_id">
                            <i class="fas fa-wallet mr-1"></i> Account
                        </label>
                        <select class="form-control select2 @error('account_id') is-invalid @enderror" name="account_id" id="account_id">
                            <option value="">Select Account</option>
                            @foreach($accounts->groupBy('type.name') as $typeName => $accountsGroup)
                                <optgroup label="{{ $typeName }}">
                                    @foreach($accountsGroup as $account)
                                        <option value="{{ $account->id }}" 
                                            {{ old('account_id', $transaction->account_id ?? '') == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('account_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="transaction_group_id">
                            <i class="fas fa-object-group mr-1"></i> Group Transaction (Optional)
                        </label>
                        <select class="form-control select2 @error('transaction_group_id') is-invalid @enderror" id="transaction_group_id" name="transaction_group_id">
                            <option value="">No Group</option>
                            @foreach($transactions as $trx)
                                    <option value="{{ $trx->id }}" {{ $transaction->transaction_group_id == $trx->id ? 'selected' : '' }}>
                                        #{{ $trx->id }} - {{ $trx->description }} ({{ $trx->amount }})
                                    </option>
                            @endforeach
                        </select>
                        @error('transaction_group_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">
                            <i class="fas fa-align-left mr-1"></i> Description
                        </label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" 
                               id="description" name="description" 
                               value="{{ old('description', $transaction->description) }}" 
                               placeholder="Enter description..." required>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="amount">
                            <i class="fas fa-money-bill-wave mr-1"></i> Amount
                        </label>
                        <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                               id="amount" name="amount" 
                               value="{{ old('amount', $transaction->amount) }}" 
                               placeholder="0.00" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="type">
                            <i class="fas fa-exchange-alt mr-1"></i> Type
                        </label>
                        <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="debit" {{ old('type', $transaction->type) == 'debit' ? 'selected' : '' }}>Debit</option>
                            <option value="credit" {{ old('type', $transaction->type) == 'credit' ? 'selected' : '' }}>Credit</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="date">
                            <i class="fas fa-calendar-alt mr-1"></i> Date
                        </label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" 
                               id="date" name="date" 
                               value="{{ old('date', $transaction->date->format('Y-m-d')) }}" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4 gap-2">
                <a href="{{ route('transactions.index') }}" class="btn btn-light border mr-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save mr-1"></i> Update Transaction
                </button>
            </div>
            
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        // Initialize select2 if needed
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });
            $('#transaction_group_id').select2({
                theme: 'bootstrap4',
                width: '100%' // Important to match Bootstrap field width
            });
            $('#account_id').select2({
                theme: 'bootstrap4',
                width: '100%' // Important to match Bootstrap field width
            });
        });
    </script>
@endpush