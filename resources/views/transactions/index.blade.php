@extends('layouts.app2')

@section('content')
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

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
   

    <div class="card">
        <div class="card-body">
            <table  class="table table-striped table-bordered nowrap" style="width:100%"  id="transactionsTable" >
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Account</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Group</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

       var table = $('#transactionsTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true, // Enable responsive feature
    ajax: "{{ route('transactions.index') }}",
    columns: [
        {data: 'id', name: 'id'},
        {data: 'account_name', name: 'account.name'},
        {data: 'description', name: 'description'},
        {data: 'amount_formatted', name: 'amount'},
        {data: 'type_badge', name: 'type'},
        {
            data: 'date',
            name: 'date',
            render: function(data, type, row) {
                if (type === 'display' || type === 'filter') {
                    // Format for display (e.g., "Apr 15, 2025")
                    return new Date(data).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                }
                return data; // Keep original format for sorting/exporting
            }
        },
        {data: 'group_description', name: 'group.description'},
        {data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 1},
    ],
   
    columnDefs: [
        { responsivePriority: 1, targets: 0 }, // ID column
        { responsivePriority: 2, targets: 7 }, // Action column
        { responsivePriority: 3, targets: 2 }  // Description column
    ]
});
});

</script>
@endpush