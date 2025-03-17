@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Level</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ route('level.create') }}">Tambah Level</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_level">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Code Level</th>
                        <th>Name Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($levels as $level)
                        <tr>
                            <td>{{ $level->level_id }}</td>
                            <td>{{ $level->level_code }}</td>
                            <td>{{ $level->level_name }}</td>
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
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#table_level').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('level.list') }}",
                    type: "POST",
                    "dataType": "json",
                    "data": function (d) {
                        d.level_id = $('#level_id').val();
                    },
                    "headers": {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: "DT_RowIndex", name: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "level_code", name: "level_code", orderable: true, searchable: true },
                    { data: "level_name", name: "level_name", orderable: true, searchable: true },
                    { data: "aksi", name: "aksi", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush