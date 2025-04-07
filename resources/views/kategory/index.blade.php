@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ route('kategory.create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id='table_kategory'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Kode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Kosong karena pakai server-side processing --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            var dataKategory = $('#table_kategory').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('kategory.list') }}",
                    type: "POST",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "kategory_name", orderable: true, searchable: true },
                    { data: "kategory_code", orderable: true, searchable: true },
                    {
                        data: "kategory_id",
                        orderable: false,
                        searchable: false,
                        render: function (id, type, row) {
                            let detailUrl = "{{ route('kategory.detail', ':id') }}".replace(':id', id);
                            let editUrl = "{{ route('kategory.edit', ':id') }}".replace(':id', id);
                            let deleteUrl = "{{ route('kategory.destroy', ':id') }}".replace(':id', id);

                            return `
                                        <div class="d-inline-flex flex-wrap gap-1">
                                            <a href="${detailUrl}" class="btn btn-info btn-sm">Detail</a>
                                            <a href="${editUrl}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="${deleteUrl}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    `;
                        }
                    }
                ]
            });
        });
    </script>
@endpush
