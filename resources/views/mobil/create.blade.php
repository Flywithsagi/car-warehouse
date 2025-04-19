<form action="{{ url('/mobil/store') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Mobil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Mobil</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan Nama Mobil"
                        required>
                    <small id="error-name" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Merk Mobil</label>
                    <input type="text" name="brand" id="brand" class="form-control" placeholder="Masukkan Merk Mobil"
                        required>
                    <small id="error-brand" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tahun Mobil</label>
                    <input type="number" name="year" id="year" class="form-control" placeholder="Masukkan Tahun Mobil"
                        required>
                    <small id="error-year" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jumlah Mobil</label>
                    <input type="number" name="quantity" id="quantity" class="form-control"
                        placeholder="Masukkan Jumlah Mobil" required>
                    <small id="error-quantity" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jenis Kendaraan</label>
                    <select name="jenis_id" id="jenis_id" class="form-control" required>
                        <option value="">Pilih Jenis Kendaraan</option>
                        @foreach($jenisList as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->name }}</option>
                        @endforeach
                    </select>
                    <small id="error-jenis_id" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $("#form-tambah").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 100
                },
                brand: {
                    required: true,
                    maxlength: 100
                },
                year: {
                    required: true,
                    digits: true,
                    minlength: 4,
                    maxlength: 4
                },
                quantity: {
                    required: true,
                    digits: true,
                    min: 1
                },
                jenis_id: {
                    required: true
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,  // pastikan rute action form mengarah ke /mobil/store
                    type: form.method,  // menggunakan POST
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide'); // menutup modal setelah berhasil
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataMobil.ajax.reload(); // reload DataTable agar data terbaru tampil
                        } else {
                            $('.error-text').text('');  // reset error text
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);  // tampilkan error validasi pada masing-masing field
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>