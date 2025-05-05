@empty($barang)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="fa fa-ban"></i> Error!!</h5>
                    Data barang tidak ditemukan.
                </div>
                <a href="{{ route('barang') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ route('barang.delete_ajax', $barang->barang_id) }}" method="POST" id="form-delete-barang">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="fas fa-exclamation-triangle"></i> Konfirmasi!</h5>
                        Apakah Anda yakin ingin menghapus barang berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Kode Barang :</th>
                            <td class="col-9">{{ $barang->barang_kode }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Barang :</th>
                            <td class="col-9">{{ $barang->barang_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Harga Jual :</th>
                            <td class="col-9">{{ number_format($barang->harga_jual) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#form-delete-barang").validate({
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            $('#myModal').modal(
                            'hide'); // pastikan id modal luar adalah 'myModal'
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataBarang.ajax.reload(null,
                                false); // reload DataTable barang
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                text: 'Terjadi kesalahan di server.'
                            });
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endempty
