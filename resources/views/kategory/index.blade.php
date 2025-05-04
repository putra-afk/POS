@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ route('kategory.create') }}">Tambah</a>
                <button onclick="modalAction('{{ route('kategory.create_ajax') }}')" class="btn btn-sm btn-success mt-1">Add
                    Ajax</button>
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
                            <select class="form-control" id="kategory_id" name="kategory_id">
                                <option value="">-- Semua --</option>
                                @foreach ($kategories as $item)
                                    <option value="{{ $item->kategory_id }}">{{ $item->kategory_name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Produk</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_kategory">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Kode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategories as $kategory)
                        <tr>
                            <td>{{ $kategory->kategory_id }}</td>
                            <td>{{ $kategory->kategory_name }}</td>
                            <td>{{ $kategory->kategory_code }}</td>
                            <td>
                                <form action="{{ route('kategory.destroy', $kategory->kategory_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('kategory.show_ajax', $kategory->kategory_id) }}"
                                        class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('kategory.edit_ajax', $kategory->kategory_id) }}"
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

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataKategory;
        $(document).ready(function() {
            dataKategory = $('#table_kategory').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('kategory.list') }}",
                    type: "POST",
                    data: function(d) {
                        d.kategory_id = $('#kategory_id').val(); // Send the selected filter value
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'kategory_id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kategory_name'
                    },
                    {
                        data: 'kategory_code'
                    },
                    {
                        data: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#kategory_id').on('change', function() {
                dataKategory.ajax.reload();
            });
        });
    </script>
@endpush
