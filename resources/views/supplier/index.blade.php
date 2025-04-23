@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ route('supplier.import.excel') }}')" class="btn btn-info">Import Supplier</button>
                <a href="{{ route('supplier.export.excel') }}" class="btn btn-sm btn-primary mt-1">
                    <i class="fa fa-file-excel"></i> Export Supplier Excel
                </a>

                <a href="{{ route('supplier.export.pdf') }}" class="btn btn-warning">
                    <i class="fa fa-fa-file-pdf"></i> Export Supplier PDF
                </a>
                <!-- <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-primary mt-1">Tambah</a> -->
                <button onclick="modalAction('{{ route('supplier.create-ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table id="table-supplier" class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div 
        id="myModal" 
        class="modal fade animate shake" 
        tabindex="-1" role="dialog" 
        data-backdrop="static" 
        data-keyboard="false" 
        data-width="75%" 
        aria-hidden="true">
    </div>
@endsection

@push('js')
<script>
    function modalAction(url) {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    let dataSupplier;
    $(document).ready(() => {
        dataSupplier = $('#table-supplier').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ route('supplier.list') }}",
                "dataType": "json",
                "type": "POST",
                "data": (d) => {
                    d.supplier_id = $('#supplier_id').val()
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "supplier_id",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "supplier_nama",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endpush