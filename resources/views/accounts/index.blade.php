@extends('layouts.app2')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Accounts</h2>
        <button type="button" class="btn btn-primary" id="createAccount">Create Account</button>
    </div>

    <!-- Add this to your accounts/index.blade.php -->



    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="accountsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Balance</th>
                        <th>Color</th>
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
        var table = $('#accountsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('accounts.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'type_name', name: 'type.name'},
                {data: 'balance', name: 'balance'},
                {data: 'color_display', name: 'color'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createAccount').click(function () {
            $('#saveBtn').val("create-account");
            $('#id').val('');
            $('#ajaxForm').trigger("reset");
            $('#modelHeading').html("Create New Account");
            $('#ajaxModel').modal('show');
            
            $('#formFields').html(`
                <div class="col-md-12">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-12">
                    <label for="type_id">Account Type</label>
                    <select class="form-control" id="type_id" name="type_id" required>
                        <option value="">Select Type</option>
                        @foreach($accountTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="color">Color</label>
                    <input type="color" class="form-control" id="color" name="color" value="#3c8dbc" title="Choose color">
                </div>
            `);
        });
        
        $('body').on('click', '.edit', function () {
            var id = $(this).data('id');
            $.get("{{ route('accounts.index') }}" +'/edit/' + id, function (data) {
                $('#modelHeading').html("Edit Account");
                $('#saveBtn').val("edit-account");
                $('#ajaxModel').modal('show');
                
                $('#formFields').html(`
                    <div class="col-md-12">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="${data.name}" required>
                    </div>
                    <div class="col-md-12">
                        <label for="type_id">Account Type</label>
                        <select class="form-control" id="type_id" name="type_id" required>
                            <option value="">Select Type</option>
                            @foreach($accountTypes as $type)
                                <option value="{{ $type->id }}" ${data.type_id == {{ $type->id }} ? 'selected' : ''}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="color">Color</label>
                        <input type="color" class="form-control" id="color" name="color" value="${data.color}" title="Choose color">
                    </div>
                `);
                
                $('#id').val(data.id);
            });
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Saving..');
            
            $.ajax({
                data: $('#ajaxForm').serialize(),
                url: "{{ route('accounts.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#ajaxForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                    $('#saveBtn').html('Save changes');
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save changes');
                }
            });
        });

        $('body').on('click', '.delete', function () {
            var id = $(this).data('id');
            if (confirm("Are you sure you want to delete?")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('accounts.store') }}"+'/'+id,
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