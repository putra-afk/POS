@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($kategory)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ route('kategory.index') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ route('kategory.update', $kategory->kategory_id) }}" class="form-horizontal">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nama Kategori</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="kategory_name" name="kategory_name"
                                value="{{ old('kategory_name', $kategory->kategory_name) }}" required>
                            @error('kategory_name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kode</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="kategory_code" name="kategory_code"
                                value="{{ old('kategory_code', $kategory->kategory_code) }}" required>
                            @error('kategory_code')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ route('kategory.index') }}">Kembali</a>
                        </div>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush