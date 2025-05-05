<div class="modal fade" id="modal-barang-detail" tabindex="-1" role="dialog" aria-labelledby="modalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @empty($barang)
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                        Data yang Anda cari tidak ditemukan.
                    </div>
                @else
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <tr>
                            <th>Kode Barang</th>
                            <td>{{ $barang->barang_kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $barang->barang_nama }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $barang->kategory->kategory_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Harga Beli</th>
                            <td>{{ number_format($barang->harga_beli) }}</td>
                        </tr>
                        <tr>
                            <th>Harga Jual</th>
                            <td>{{ number_format($barang->harga_jual) }}</td>
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
    $('#modal-barang-detail').modal('show');

    $('#modal-barang-detail').on('hidden.bs.modal', function() {
        $(this).remove();
    });
</script>
