@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ route('stok.create') }}">Tambah</a>
                <button onclick="modalAction('{{ route('stok.create_ajax') }}')" class="btn btn-sm btn-success mt-1">Add
                    Ajax</button>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="barang_id" name="barang_id">
                                <option value="">-- Semua --</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Nama Barang</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stoks as $stok)
                        <tr>
                            <td>{{ $stok->stok_id }}</td>
                            <td>{{ $stok->barang->barang_nama ?? '-' }}</td>
                            <td>{{ $stok->stok_jumlah }}</td>
                            <td>
                                <form action="{{ route('stok.destroy', $stok->stok_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('stok.show_ajax', $stok->stok_id) }}"
                                        class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('stok.edit_ajax', $stok->stok_id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataStok;
        $(document).ready(function() {
            dataStok = $('#table_stok').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('stok.list') }}",
                    type: "POST",
                    data: function(d) {
                        d.barang_id = $('#barang_id').val();
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'stok_id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'barang_nama'
                    },
                    {
                        data: 'stok_jumlah'
                    },
                    {
                        data: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#barang_id').on('change', function() {
                dataStok.ajax.reload();
            });
        });
    </script>
@endpush
