@extends('layouts.app2')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Account Types</h2>
        <button type="button" class="btn btn-primary" id="createAccountType">Create Account Type</button>
    </div>

    <!-- Add this to your account_types/index.blade.php -->
    

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="accountTypesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
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
        var table = $('#accountTypesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('account-types.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'slug', name: 'slug'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createAccountType').click(function () {
            $('#saveBtn').val("create-account-type");
            $('#id').val('');
            $('#ajaxForm').trigger("reset");
            $('#modelHeading').html("Create New Account Type");
            $('#ajaxModel').modal('show');
            
            $('#formFields').html(`
                <div class="col-md-12">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-12">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" required>
                </div>
            `);
        });

        $('body').on('click', '.edit', function () {
            var id = $(this).data('id');
            $.get("{{ route('account-types.index') }}" +'/edit/' + id, function (data) {
                $('#modelHeading').html("Edit Account Type");
                $('#saveBtn').val("edit-account-type");
                $('#ajaxModel').modal('show');
                
                $('#formFields').html(`
                    <div class="col-md-12">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="${data.name}" required>
                    </div>
                    <div class="col-md-12">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="${data.slug}" required>
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
                url: "{{ route('account-types.store') }}",
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
                    url: "{{ route('account-types.store') }}"+'/'+id,
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