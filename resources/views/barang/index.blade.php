@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ route('barang.import') }}')" class="btn btn-sm btn-info mt-1">Import
                    Data</button>
                <a class="btn btn-sm btn-primary mt-1" href="{{ route('barang.create') }}">Tambah</a>
                <button onclick="modalAction('{{ route('barang.create_ajax') }}')" class="btn btn-sm btn-success mt-1">Add
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
                            <select class="form-control" id="kategory_id" name="kategory_id">
                                <option value="">-- Semua --</option>
                                @foreach ($kategory as $item)
                                    <option value="{{ $item->kategory_id }}">{{ $item->kategory_name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Barang</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang as $item)
                        <tr>
                            <td>{{ $item->barang_id }}</td>
                            <td>{{ $item->barang_kode }}</td>
                            <td>{{ $item->barang_nama }}</td>
                            <td>{{ $item->kategory->kategory_name ?? '-' }}</td>
                            <td>{{ number_format($item->harga_beli) }}</td>
                            <td>{{ number_format($item->harga_jual) }}</td>
                            <td>
                                <form action="{{ route('barang.destroy', $item->barang_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('barang.show_ajax', $item->barang_id) }}"
                                        class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('barang.edit_ajax', $item->barang_id) }}"
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

        var dataBarang;
        $(document).ready(function() {
            dataBarang = $('#table_barang').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('barang.list') }}",
                    type: "POST",
                    data: function(d) {
                        d.kategory_id = $('#kategory_id').val();
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'barang_id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'barang_kode'
                    },
                    {
                        data: 'barang_nama'
                    },
                    {
                        data: 'kategory.kategory_name',
                        defaultContent: '-'
                    },
                    {
                        data: 'harga_beli'
                    },
                    {
                        data: 'harga_jual'
                    },
                    {
                        data: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#kategory_id').on('change', function() {
                dataBarang.ajax.reload();
            });
        });
    </script>
@endpush
