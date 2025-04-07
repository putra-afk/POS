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
                        <th>Nama Level</th>
                        <th>Kode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Kosong karena pakai server-side --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            var dataUser = $('#table_level').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('level.list') }}",
                    type: "POST",
                    dataType: "json",
                    data: function (d) {
                        d.level_id = $('#level_id').val();
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "level_name", orderable: true, searchable: true },
                    { data: "level_code", orderable: true, searchable: true },
                    {
                        data: "level_id",
                        orderable: false,
                        searchable: false,
                        render: function (id, type, row) {
                            let detailUrl = "{{ route('level.detail', ':id') }}".replace(':id', id);
                            let editUrl = "{{ route('level.edit', ':id') }}".replace(':id', id);
                            let deleteUrl = "{{ route('level.destroy', ':id') }}".replace(':id', id);

                            return `
                                    <div class="d-inline-flex flex-wrap gap-1">
                                        <a href="${detailUrl}" class="btn btn-sm btn-info">Detail</a>
                                        <a href="${editUrl}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="${deleteUrl}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                `;
                        }
                    }
                ]
            });

            $('#level_id').on('change', function () {
                dataUser.ajax.reload();
            });
        });
    </script>
@endpush
