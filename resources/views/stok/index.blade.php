@php $activeMenu = 'stok'; @endphp
@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $page->title }}</h3>
            <a href="{{ route('stok.create') }}" class="btn btn-primary btn-sm float-right">Tambah</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stok as $item)
                        <tr>
                            <td>{{ $item->barang->barang_nama ?? '-' }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('stok.show', $item->stok_id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('stok.edit', $item->stok_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('stok.destroy', $item->stok_id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus stok ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
