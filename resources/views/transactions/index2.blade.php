@extends('layouts.app2')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Transactions</h2>
        <button type="button" class="btn btn-primary" id="createTransaction">Create Transaction</button>
    </div>


   

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
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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
        {data: 'date', name: 'date'},
        {data: 'group_description', name: 'group.description'},
        {data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 1},
    ],
   
    columnDefs: [
        { responsivePriority: 1, targets: 0 }, // ID column
        { responsivePriority: 2, targets: 7 }, // Action column
        { responsivePriority: 3, targets: 2 }  // Description column
    ]
});
$('#createTransaction').click(function () {
    $('#saveBtn').val("create-transaction");
    $('#id').val('');
    $('#ajaxForm').trigger("reset");
    $('#modelHeading').html("Create New Transaction");
    $('#ajaxModel').modal('show');

    $('#formFields').html(`
        <div class="container-fluid">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="account_id">Account</label>
                    <select class="form-control select2" id="account_id" name="account_id" required>
                        <option value="">Select Account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="account_id-error"></div>
                </div>
                <div class="form-group col-md-12">
                    <label for="transaction_group_id">Group Transaction (Optional)</label>
                    <select class="form-control select2" id="transaction_group_id" name="transaction_group_id">
                        <option value="">No Group</option>
                        @foreach($transactions as $transaction)
                            <option value="{{ $transaction->id }}">#{{ $transaction->id }} - {{ $transaction->description }} ({{ $transaction->amount }})</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="transaction_group_id-error"></div>
                </div>
                <div class="form-group col-md-12">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Enter description..." required>
                    <div class="invalid-feedback" id="description-error"></div>
                </div>
                <div class="form-group col-md-6">
                    <label for="amount">Amount</label>
                    <input type="number" step="0.01" class="form-control" id="amount" name="amount" placeholder="0.00" required>
                    <div class="invalid-feedback" id="amount-error"></div>
                </div>
                <div class="form-group col-md-6">
                    <label for="type">Type</label>
                    <select class="form-control select2" id="type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="debit">Debit</option>
                        <option value="credit">Credit</option>
                    </select>
                    <div class="invalid-feedback" id="type-error"></div>
                </div>
                <div class="form-group col-md-12">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                    <div class="invalid-feedback" id="date-error"></div>
                </div>
            </div>
        </div>
    `);

    // Initialize select2 after appending the form
    $('.select2').select2({
        dropdownParent: $('#ajaxModel'), // This ensures dropdown appears correctly inside modal
        width: '100%' // Ensures proper width
    });
});



$('body').on('click', '.edit', function () {
    var id = $(this).data('id');
    $.get("{{ route('transactions.index') }}" + '/edit/' + id, function (data) {
        $('#modelHeading').html("Edit Transaction");
        $('#saveBtn').val("edit-transaction");
        
        $('#formFields').html(`
            <div class="container-fluid">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="account_id">Account</label>
                        <select class="form-control select2" id="account_id" name="account_id" required>
                            <option value="">Select Account</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" ${data.account_id == {{ $account->id }} ? 'selected' : ''}>{{ $account->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="account_id-error"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="transaction_group_id">Group Transaction (Optional)</label>
                        <select class="form-control select2" id="transaction_group_id" name="transaction_group_id">
                            <option value="">No Group</option>
                            @foreach($transactions as $transaction)
                                <option value="{{ $transaction->id }}" ${data.transaction_group_id == {{ $transaction->id }} ? 'selected' : ''}>
                                    #{{ $transaction->id }} - {{ $transaction->description }} ({{ $transaction->amount }})
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="transaction_group_id-error"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" value="${data.description}" required>
                        <div class="invalid-feedback" id="description-error"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="amount">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="${data.amount}" required>
                        <div class="invalid-feedback" id="amount-error"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="type">Type</label>
                        <select class="form-control select2" id="type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="debit" ${data.type == 'debit' ? 'selected' : ''}>Debit</option>
                            <option value="credit" ${data.type == 'credit' ? 'selected' : ''}>Credit</option>
                        </select>
                        <div class="invalid-feedback" id="type-error"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="${data.date}" required>
                        <div class="invalid-feedback" id="date-error"></div>
                    </div>
                </div>
            </div>
        `);

        $('#id').val(data.id);
        
        // Initialize Select2 after the modal is shown and elements exist
            $('.select2').select2({
                dropdownParent: $('#ajaxModel'),
                width: '100%'
            });
        
        
        $('#ajaxModel').modal('show');
    });
});
    
function displayErrors(errors) {
    // Clear previous errors
    $('.invalid-feedback').text('');
    $('.form-control').removeClass('is-invalid');
    
    // Display new errors
    for (const [field, messages] of Object.entries(errors)) {
        const errorElement = $(`#${field}-error`);
        const inputElement = $(`#${field}`);
        
        if (errorElement.length && inputElement.length) {
            inputElement.addClass('is-invalid');
            errorElement.text(messages[0]);
        }
    }
}

$('#saveBtn').click(function (e) {
    e.preventDefault();
    $(this).html('Saving..');
    
    $.ajax({
        data: $('#ajaxForm').serialize(),
        url: "{{ route('transactions.store') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
            $('#ajaxForm').trigger("reset");
            $('#ajaxModel').modal('hide');
            table.draw();
            $('#saveBtn').html('Save changes');
        },
        error: function (xhr) {
            $('#saveBtn').html('Save changes');
            if (xhr.status === 422) {
                // Validation error
                displayErrors(xhr.responseJSON.errors);
            } else {
                // Other error
                console.log('Error:', xhr.responseText);
            }
        }
    });
});

        
        $('body').on('click', '.delete', function () {
            var id = $(this).data('id');
            if (confirm("Are you sure you want to delete?")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('transactions.store') }}"+'/'+id,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
    });
</script>
@endpush