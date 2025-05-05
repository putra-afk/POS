@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ route('barang.create') }}" class="btn btn-sm btn-primary mt-1">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->barang_kode }}</td>
                            <td>{{ $item->barang_nama }}</td>
                            <td>{{ $item->kategory->kategory_name ?? '-' }}</td>
                            <td>{{ number_format($item->harga_beli) }}</td>
                            <td>{{ number_format($item->harga_jual) }}</td>
                            <td>
                                <form action="{{ route('barang.destroy', $item->barang_id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('barang.show', $item->barang_id) }}"
                                        class="btn btn-sm btn-info me-1 mb-1">Detail</a>
                                    <a href="{{ route('barang.edit', $item->barang_id) }}"
                                        class="btn btn-sm btn-warning me-1 mb-1">Edit</a>
                                    <button class="btn btn-sm btn-danger mb-1">Hapus</button>
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
            $('#table_barang').DataTable();
        });
    </script>
@endpush
