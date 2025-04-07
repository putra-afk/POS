@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $page->title }}</h3>
            <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm float-right">Tambah</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barang as $item)
                        <tr>
                            <td>{{ $item->barang_kode }}</td>
                            <td>{{ $item->barang_nama }}</td>
                            <td>{{ $item->kategory->kategory_name ?? '-' }}</td>
                            <td>{{ number_format($item->harga_beli) }}</td>
                            <td>{{ number_format($item->harga_jual) }}</td>
                            <td>
                                <a href="{{ route('barang.show', $item->barang_id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('barang.edit', $item->barang_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('barang.destroy', $item->barang_id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
