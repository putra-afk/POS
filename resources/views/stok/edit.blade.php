@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('stok.update', $stok->stok_id) }}">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Barang</label>
                    <select name="barang_id" class="form-control" required>
                        @foreach($barang as $item)
                            <option value="{{ $item->barang_id }}" {{ $stok->barang_id == $item->barang_id ? 'selected' : '' }}>
                                {{ $item->barang_nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" value="{{ $stok->jumlah }}" required>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" value="{{ $stok->keterangan }}">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('stok.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
