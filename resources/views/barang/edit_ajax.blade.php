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
                <a href="{{ route('barang.index') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/barang/' . $barang->barang_id . '/update_ajax') }}" method="POST" id="form-edit-barang">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="barang_kode">Kode Barang</label>
                        <input type="text" name="barang_kode" id="barang_kode" class="form-control"
                            value="{{ $barang->barang_kode }}" required>
                        <small id="error-barang_kode" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="barang_nama">Nama Barang</label>
                        <input type="text" name="barang_nama" id="barang_nama" class="form-control"
                            value="{{ $barang->barang_nama }}" required>
                        <small id="error-barang_nama" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="kategory_id">Kategory</label>
                        <select name="kategory_id" id="kategory_id" class="form-control" required>
                            <option value="">-- Pilih Kategory --</option>
                            @foreach ($kategory as $kat)
                                <option value="{{ $kat->kategory_id }}"
                                    {{ $barang->kategory_id == $kat->kategory_id ? 'selected' : '' }}>
                                    {{ $kat->kategory_name }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-kategory_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control"
                            value="{{ $barang->harga_beli }}" required>
                        <small id="error-harga_beli" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="number" name="harga_jual" id="harga_jual" class="form-control"
                            value="{{ $barang->harga_jual }}" required>
                        <small id="error-harga_jual" class="error-text form-text text-danger"></small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#form-edit-barang").validate({
                rules: {
                    barang_kode: {
                        required: true,
                        minlength: 3
                    },
                    barang_nama: {
                        required: true,
                        minlength: 3
                    },
                    kategory_id: {
                        required: true,
                        number: true
                    },
                    harga_beli: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    harga_jual: {
                        required: true,
                        number: true,
                        min: 0
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.message
                                });
                                dataBarang.ajax.reload(); // pastikan variabel ini sesuai
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
