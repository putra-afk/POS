@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of Items</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/goods/import') }}')" class="btn btn-info">Import Goods</button>
                <a href="{{ url('/item/create') }}" class="btn btn-primary">Add Data</a>
                <button onclick="modalAction('{{ url('/item/create_ajax') }}')" class="btn btn-success">Add Data
                    (Ajax)</button>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter -->
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm row text-sm mb-0">
                            <label for="filter_kategori" class="col-md-1 col-form-label">Filter</label>
                            <div class="col-md-3">
                                <select name="filter_kategori" class="form-control form-control-sm filter_kategori">
                                    <option value="">- All -</option>
                                    @foreach ($kategori as $l)
                                        <option value="{{ $l->kategori_id }}">{{ $l->kategori_nama }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Item Category</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- DataTable -->
            <table class="table table-bordered table-sm table-striped table-hover" id="table-item">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Purchase Price</th>
                        <th>Selling Price</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var tableItem;
        $(document).ready(function() {
            tableItem = $('#table-item').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('item/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.filter_kategori = $('.filter_kategori').val();
                    }
                },
                columns: [{
                        data: 'No_Urut',
                        className: "text-center",
                        width: "5%",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'barang_kode',
                        width: "10%",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'barang_nama',
                        width: "37%",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'harga_beli',
                        width: "10%",
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return new Intl.NumberFormat('id-ID').format(data);
                        }
                    },
                    {
                        data: 'harga_jual',
                        width: "10%",
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return new Intl.NumberFormat('id-ID').format(data);
                        }
                    },
                    {
                        data: 'kategori.kategori_nama',
                        width: "14%",
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'action',
                        className: "text-center",
                        width: "14%",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Custom search on Enter
            $('#table-item_filter input').unbind().bind('keyup', function(e) {
                if (e.keyCode == 13) {
                    tableItem.search(this.value).draw();
                }
            });

            // Filter by kategori
            $('.filter_kategori').change(function() {
                tableItem.draw();
            });
        });
    </script>
@endpush
