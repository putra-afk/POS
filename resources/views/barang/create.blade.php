@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $page->title }}</h3>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="barang_kode">Kode Barang</label>
                    <input type="text" name="barang_kode" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="barang_nama">Nama Barang</label>
                    <input type="text" name="barang_nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Kategory</label>
                    <select name="kategory_id" class="form-control" required>
                        <option value="">-- Pilih Kategory --</option>
                        @foreach($kategory as $kat)
                            <option value="{{ $kat->kategory_id }}">{{ $kat->kategory_id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="harga_beli">Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
