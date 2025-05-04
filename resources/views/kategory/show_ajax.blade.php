<div class="modal fade" id="modal-kategory-detail" tabindex="-1" role="dialog" aria-labelledby="modalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @empty($kategory)
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                        Data yang Anda cari tidak ditemukan.
                    </div>
                @else
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <tr>
                            <th>ID</th>
                            <td>{{ $kategory->kategory_id }}</td>
                        </tr>
                        <tr>
                            <th>Nama Kategori</th>
                            <td>{{ $kategory->kategory_name }}</td>
                        </tr>
                        <tr>
                            <th>Kategori Code</th>
                            <td>{{ $kategory->kategory_code }}</td>
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
    $('#modal-kategory-detail').modal('show');

    $('#modal-kategory-detail').on('hidden.bs.modal', function() {
        $(this).remove();
    });
</script>
