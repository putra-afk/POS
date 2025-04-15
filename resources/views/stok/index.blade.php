@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ route('stok.create') }}" class="btn btn-sm btn-primary mt-1">Tambah</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Stok</th>
                        <th>Tanggal Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stok as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->barang->barang_nama ?? '-' }}</td>
                            <td>{{ $item->stok_jumlah }}</td>
                            <td>{{ $item->stok_tanggal }}</td>
                            <td>
                                <form action="{{ route('stok.destroy', $item->stok_id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('stok.show', $item->stok_id) }}"
                                        class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('stok.edit', $item->stok_id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#table_stok').DataTable();
        });
    </script>
@endpush
