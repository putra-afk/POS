@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nama Barang</th>
                    <td>{{ $stok->barang->barang_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>{{ $stok->stok_jumlah }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $stok->created_at ?? '-' }}</td>
                </tr>
            </table>
            <a href="{{ route('stok.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
