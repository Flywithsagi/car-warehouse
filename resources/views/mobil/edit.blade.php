@if(empty($mobil))
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/mobil/' . $mobil->id . '/update') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Mobil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Mobil</label>
                        <input type="text" name="name" class="form-control" value="{{ $mobil->name }}" required>
                        <small class="text-danger error-text" id="error-name"></small>
                    </div>
                    <div class="form-group">
                        <label>Merk Mobil</label>
                        <input type="text" name="brand" class="form-control" value="{{ $mobil->brand }}" required>
                        <small class="text-danger error-text" id="error-brand"></small>
                    </div>
                    <div class="form-group">
                        <label>Tahun</label>
                        <input type="number" name="year" class="form-control" value="{{ $mobil->year }}" min="1900"
                            required>
                        <small class="text-danger error-text" id="error-year"></small>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="quantity" class="form-control" value="{{ $mobil->quantity }}" min="1"
                            required>
                        <small class="text-danger error-text" id="error-quantity"></small>
                    </div>
                    <div class="form-group">
                        <label>Jenis Mobil</label>
                        <select name="jenis_id" class="form-control" required>
                            <option value="">-- Pilih Jenis --</option>
                            @foreach($listJenis as $item)
                                <option value="{{ $item->id }}" {{ $mobil->jenis_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} - {{ $item->type }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger error-text" id="error-jenis_id"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $('#form-edit').on('submit', function (e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function (res) {
                        $('.error-text').text('');
                        if (res.status) {
                            $('#myModal').modal('hide');
                            Swal.fire('Berhasil', res.message, 'success');
                            dataMobil.ajax.reload(); // reload datatable
                        } else {
                            $.each(res.msgField, function (key, val) {
                                $('#error-' + key).text(val[0]);
                            });
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    }
                });
            });
        });
    </script>
@endif