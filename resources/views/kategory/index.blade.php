@php $activeMenu = 'kategory'; @endphp
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
            {{-- Alerts --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Table --}}
            <table class="table table-bordered table-striped table-hover table-sm" id="table_kategory">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Kode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategories as $index => $kategory)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $kategory->kategory_name }}</td>
                            <td>{{ $kategory->kategory_code }}</td>
                            <td>
                                <form action="{{ route('kategory.destroy', $kategory->kategory_id) }}" method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('kategory.detail', $kategory->kategory_id) }}"
                                        class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('kategory.edit', $kategory->kategory_id) }}"
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
        $(document).ready(function() {
            $('#table_kategory').DataTable();
        });
    </script>
@endpush
