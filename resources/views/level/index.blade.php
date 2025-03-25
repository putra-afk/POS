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

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="level_id" name="level_id" required>
                                <option value="">-- Semua --</option>
                                @foreach($levels as $item)
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
                        <th>Name</th>
                        <th>Code</th>
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
                                <form action="{{ route('level.destroy', $level->level_id) }}" method="post">
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
@endsection

    @push('css')
    @endpush

    @push('js')
        <script>
            $(document).ready(function () {
                console.log('test')
                var dataUser = $('#table_level').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        "url": "{{ route('level.list') }}",
                        "type": "POST",
                        "dataType": "json",
                        "data": function (d) {
                            d.level_id = $('#level_id').val();
                        },
                        "headers": {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [
                        { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                        { data: "level_name", orderable: true, searchable: true },
                        { data: "level_code", orderable: true, searchable: true },
                        { data: "aksi", orderable: false, searchable: false }
                    ]
                });
                $('#level_id').on('change', function () {
                    dataUser.ajax.reload();
                });
            });
        </script>
    @endpush