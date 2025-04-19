@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <!-- Tombol Tambah -->
                <button onclick="modalAction('{{ url('mobil/create') }}')" class="btn btn-sm btn-success mt-1">
                    Tambah
                </button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_mobil">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Mobil</th>
                        <th>Nama Mobil</th>
                        <th>Merk Mobil</th>
                        <th>Tahun Mobil</th>
                        <th>Jumlah</th>
                        <th>Jenis Kendaraan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
    <style>
        /* Bikin filter dan search sejajar */
        #table_mobil_wrapper .dataTables_filter {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        #table_mobil_wrapper .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0;
        }

        #search_jenis {
            min-width: 160px;
        }
    </style>
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        let dataMobil = $('#table_mobil').DataTable({
            dom: '<"row mb-2"<"col-sm-12 col-md-6"f><"col-sm-12 col-md-6 text-right"l>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            serverSide: true,
            ajax: {
                url: "{{ url('mobil/list') }}",
                type: "POST",
                data: function (d) {
                    d.search_jenis = $('#search_jenis').val();
                }
            },
            columns: [
                { data: "id", className: "text-center" },
                { data: "kode_mobil" },
                { data: "name" },
                { data: "brand" },
                { data: "year" },
                { data: "quantity" },
                { data: "jenis" },
                { data: "aksi", className: "text-center", orderable: false, searchable: false }
            ],
            initComplete: function () {
                $('#table_mobil_filter').prepend(`
                                    <label>Jenis:
                                        <select id="search_jenis" class="form-control form-control-sm">
                                            <option value="">Semua Jenis</option>
                                            @foreach($jenis as $j)
                                                <option value="{{ $j->name }}">{{ $j->name }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                `);

                $('#search_jenis').on('change', function () {
                    dataMobil.draw();
                });
                // Menambahkan placeholder pada input pencarian
                $('#table_mobil_filter input').attr('placeholder', 'Cari Mobil...');
            }
        });
    </script>
@endpush