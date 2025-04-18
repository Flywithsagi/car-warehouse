@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <!-- Tombol Tambah -->
                <button onclick="modalAction('{{ url('jenis/create') }}')" class="btn btn-sm btn-success mt-1">
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

            <table class="table table-bordered table-striped table-hover table-sm" id="table_jenis">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Jenis</th>
                        <th>Tipe Jenis</th>
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
        var dataJenis;
        $(document).ready(function () {
            dataJenis = $('#table_jenis').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('jenis/list') }}",
                    dataType: "json",
                    type: "POST"
                },
                columns: [
                    {
                        data: "DT_RowIndex", // Menampilkan nomor urut
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "name", // Kolom nama jenis
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "type", // Kolom tipe jenis
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi", // Kolom aksi
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush