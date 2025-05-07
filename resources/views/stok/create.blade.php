@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('stok.store') }}" class="form-horizontal">
                @csrf

                {{-- Pilih Barang --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Barang</label>
                    <div class="col-10">
                        <select class="form-control" name="barang_id" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->barang_id }}"
                                    {{ old('barang_id') == $item->barang_id ? 'selected' : '' }}>
                                    {{ $item->barang_nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Jumlah Stok --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Jumlah Stok</label>
                    <div class="col-10">
                        <input type="number" class="form-control" name="stok_jumlah" value="{{ old('stok_jumlah') }}"
                            required min="1">
                        @error('stok_jumlah')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Hidden Fields for Timestamps and User ID --}}
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <!-- Automatically set to the authenticated user's ID -->
                <input type="hidden" name="stok_tanggal" value="{{ now()->format('Y-m-d') }}">
                <!-- Set current date as stock date -->

                {{-- Tombol --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label"></label>
                    <div class="col-10">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ route('stok.index') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
