@if(session('error'))
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    {{ session('error') }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Tutup</button>
            </div>
        </div>
    </div>
@else
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Mobil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-sm">
                    <tr>
                        <th>ID Mobil</th>
                        <td>{{ $mobil->id }}</td>
                    </tr>
                    <tr>
                        <th>Kode Mobil</th>
                        <td>{{ $mobil->kode_mobil }}</td>
                    </tr>
                    <tr>
                        <th>Nama Mobil</th>
                        <td>{{ $mobil->name }}</td>
                    </tr>
                    <tr>
                        <th>Merk Mobil</th>
                        <td>{{ $mobil->brand }}</td>
                    </tr>
                    <tr>
                        <th>Tahun Mobil</th>
                        <td>{{ $mobil->year }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Mobil</th>
                        <td>{{ $mobil->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Mobil</th>
                        <td>{{ $jenis->name }}</td>
                    </tr>
                    <tr>
                        <th>Tipe Jenis</th>
                        <td>{{ $jenis->type }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Tutup</button>
            </div>
        </div>
    </div>
@endif