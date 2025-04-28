<div class="modal fade" id="modal-user-detail" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @empty($user)
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                        Data yang Anda cari tidak ditemukan.
                    </div>
                @else
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <tr>
                            <th>ID</th>
                            <td>{{ $user->user_id }}</td>
                        </tr>
                        <tr>
                            <th>Level</th>
                            <td>{{ $user->level->level_name }}</td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $user->nama }}</td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td>
                                <div class="input-group">
                                    <input type="password" id="password-field" class="form-control form-control-sm"
                                        value="password" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                            id="toggle-password">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                @endempty
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#modal-user-detail').modal('show');

    $('#modal-user-detail').on('hidden.bs.modal', function() {
        $(this).remove(); // hapus elemen modal dari DOM setelah ditutup
    });

    $('#toggle-password').on('click', function() {
        let passwordField = $('#password-field');
        let passwordFieldType = passwordField.attr('type');
        let icon = $(this).find('i');

        if (passwordFieldType === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
</script>
