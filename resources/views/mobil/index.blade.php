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
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }
        var dataMobil;
        $(document).ready(function () {
            dataMobil = $('#table_mobil').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('mobil/list') }}",
                    dataType: "json",
                    type: "POST"
                },
                columns: [
                    {
                        data: "id",
                        className: "text-center",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "name", // Kolom nama mobil
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "brand", // Kolom merk mobil
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "year", // Kolom tahun mobil
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "quantity", // Kolom jumlah mobil
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "jenis_id", // Kolom jenis kendaraan
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi", // Kolom aksi
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush