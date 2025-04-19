@empty($mobil)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang Anda cari tidak ditemukan
                </div>
                <a href="{{ url('/mobil') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/mobil/' . $mobil->id . '/delete') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Mobil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda yakin ingin menghapus data mobil berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Nama Mobil:</th>
                            <td class="col-9">{{ $mobil->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Merk:</th>
                            <td class="col-9">{{ $mobil->brand }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tahun:</th>
                            <td class="col-9">{{ $mobil->year }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jumlah:</th>
                            <td class="col-9">{{ $mobil->quantity }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jenis:</th>
                            <td class="col-9">{{ $mobil->jenis->name ?? '-' }} - {{ $mobil->jenis->type ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#form-delete").submit(function (e) {
                e.preventDefault();

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, Hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $(this).attr('action'),
                            type: $(this).attr('method'),
                            data: $(this).serialize(),
                            success: function (response) {
                                if (response.status) {
                                    $('#myModal').modal('hide');
                                    Swal.fire('Berhasil', response.message, 'success');
                                    dataMobil.ajax.reload();
                                } else {
                                    Swal.fire('Gagal', response.message, 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Error', 'Terjadi kesalahan saat menghapus data.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endempty