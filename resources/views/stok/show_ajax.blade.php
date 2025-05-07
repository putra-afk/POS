<div class="modal fade" id="modal-stok-detail" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @empty($stok)
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                        Data yang Anda cari tidak ditemukan.
                    </div>
                @else
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $stok->barang->barang_nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Stok</th>
                            <td>{{ $stok->stok_jumlah }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $stok->created_at ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $stok->updated_at ?? '-' }}</td>
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
    $('#modal-stok-detail').modal('show');

    $('#modal-stok-detail').on('hidden.bs.modal', function() {
        $(this).remove();
    });
</script>
