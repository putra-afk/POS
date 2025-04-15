@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ route('level.create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="level_id" name="level_id">
                                <option value="">-- Semua --</option>
                                @foreach ($levels as $item)
                                    <option value="{{ $item->level_id }}">{{ $item->level_name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Level Pengguna</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id='table_level'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Level</th>
                        <th>Kode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($levels as $level)
                        <tr>
                            <td>{{ $level->level_id }}</td>
                            <td>{{ $level->level_name }}</td>
                            <td>{{ $level->level_code }}</td>
                            <td>
                                <form action="{{ route('level.destroy', $level->level_id) }}" method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('level.detail', $level->level_id) }}"
                                        class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('level.edit', $level->level_id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
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
        // Jika tidak pakai server-side, datatables bisa jalan tanpa ajax
        $(document).ready(function() {
            $('#table_level').DataTable();

            $('#level_id').on('change', function() {
                // Jika perlu reload manual
                $('#table_level').DataTable().search(this.value).draw();
            });
        });
    </script>
@endpush
