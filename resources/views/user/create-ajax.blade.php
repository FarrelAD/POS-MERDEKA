<form id="form-tambah" action="{{ route('user.store-ajax') }}" method="post">
    @csrf

    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="level_id">Level Pengguna</label>
                    <select name="level_id" id="level_id" class="form-control" required>
                        <option value="">- Pilih Level -</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->level_id }}">{{ $level->level_name }}</option>
                        @endforeach
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>
    
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>
    
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <small id="error-password" class="error-text form-text text-danger"></small>
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
                level_id: { required: true, number: true },
                username: { required: true, minlength: 3, maxlength: 20 },
                nama: { required: true, minlength: 3, maxlength: 100 },
                password: { required: true, minlength: 6, maxlength: 20 }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(res) {
                        if (res.status) {
                            $('#myModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message
                            });

                            dataUser.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(res.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: res.message
                            });
                        }
                    },
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
