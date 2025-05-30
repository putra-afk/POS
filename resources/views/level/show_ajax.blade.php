<div class="modal fade" id="modal-level-detail" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @empty($level)
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                        Data yang Anda cari tidak ditemukan.
                    </div>
                @else
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <tr>
                            <th>ID</th>
                            <td>{{ $level->level_id }}</td>
                        </tr>
                        <tr>
                            <th>Kode Level</th>
                            <td>{{ $level->level_code }}</td>
                        </tr>
                        <tr>
                            <th>Nama Level</th>
                            <td>{{ $level->level_name }}</td>
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
    $('#modal-level-detail').modal('show');

    $('#modal-level-detail').on('hidden.bs.modal', function() {
        $(this).remove();
    });
</script>
