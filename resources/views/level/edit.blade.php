@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            @empty($level)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data level tidak ditemukan.
                </div>
                <a href="{{ route('level') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ route('level.update', $level->level_id) }}" class="form-horizontal">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Nama Level</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="level_name" name="level_name"
                                value="{{ old('level_name', $level->level_name) }}" required>
                            @error('level_name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Kode Level</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="level_code" name="level_code"
                                value="{{ old('level_code', $level->level_code) }}" required>
                            @error('level_code')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-10 offset-2">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('level') }}">Kembali</a>
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
