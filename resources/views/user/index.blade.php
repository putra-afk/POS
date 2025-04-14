@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ route('user.create') }}">Tambah</a>
                <button onclick="modalAction('{{ route('user.create_ajax') }}')" class="btn btn-sm btn-success mt-1">Add
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

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="level_id" name="level_id" required>
                                <option value="">-- Semua --</option>
                                @foreach ($level as $item)
                                    <option value="{{ $item->level_id }}">{{ $item->level_name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Level Pengguna</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id='table_user'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Level Pengguna</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->user_id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->level->level_name }}</td>
                            <td>
                                <form action="{{ route('user.destroy', $user->user_id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a onclick="modalAction('{{ route('user.show_ajax', $user->user_id) }}')"
                                        class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('user.edit_ajax', $user->user_id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    @endsection

    @push('css')
    @endpush

    @push('js')
        <script>
            function modalAction(url = '') {
                $('#myModal').load(url, function() {
                    $('#myModal').modal('show');
                });
            }

            var dataUser;
            $(document).ready(function() {
                dataUser = $('#table_user').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        "url": "{{ route('user.list') }}",
                        "type": "POST",
                        "dataType": "json",
                        "data": function(d) {
                            d.level_id = $('#level_id').val();
                        },
                        "headers": {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            className: "text-center",
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: "username",
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: "nama",
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: "level.level_name",
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: "aksi",
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
                $('#level_id').on('change', function() {
                    dataUser.ajax.reload();
                });
            });
        </script>
    @endpush
