<form id="form-tambah" action="{{ route('supplier.store-ajax') }}" method="post">
    @csrf

    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">Tambah Data Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama supplier</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="supplier_nama" name="supplier_nama" value="{{ old('supplier_nama') }}" required>

                        @error('supplier_nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kontak</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="kontak" name="kontak" value="{{ old('kontak') }}" required>

                        @error('kontak')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Alamat</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}" required>

                        @error('alamat')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#form-tambah').validate({
            rules: {
                supplier_nama: { required: true, minlength: 5,  maxlength: 100 },
                kontak: { required: true, minlength: 5, maxlength: 20 },
                alamat: { required: true, minlength: 5, maxlength: 100 }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(res, textStatus, xhr) {
                        if (xhr.status == 200) {
                            $('#myModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message
                            });

                            dataSupplier.ajax.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan!'
                        });

                        if (xhr.responseJSON && xhr.responseJSON.msgField) {
                            $('.error-text').text('');
                            $.each(xhr.responseJSON.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: (error, element) => {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: (element, errorClass, validClass) => {
                $(element).addClass('is-invalid');
            },
            unhighlight: (element, errorClass, validClass) => {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
