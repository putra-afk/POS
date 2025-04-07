@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $page->title }}</h3>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Kode Barang</th>
                    <td>{{ $barang->barang_kode }}</td>
                </tr>
                <tr>
                    <th>Nama Barang</th>
                    <td>{{ $barang->barang_nama }}</td>
                </tr>
                <tr>
                    <th>Kategory</th>
                    <td>{{ $barang->kategory->kategory_id }}</td>
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
        </div>
    </div>
@endsection
