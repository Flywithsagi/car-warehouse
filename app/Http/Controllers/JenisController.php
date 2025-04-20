<?php
namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class JenisController extends Controller
{
    // Menampilkan halaman utama daftar jenis kendaraan
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Jenis Kendaraan',
            'list' => ['Home', 'Jenis']
        ];

        $page = (object) [
            'title' => 'Daftar jenis Kendaraan yang tersedia dalam sistem'
        ];

        $activeMenu = 'jenis';

        return view('jenis.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    // Mengambil data jenis untuk ditampilkan dalam DataTables (format JSON)
    public function list(Request $request)
    {
        $jenis = Jenis::select('id', 'name', 'type');

        return DataTables::of($jenis)
            ->addIndexColumn() // Menambahkan nomor urut
            ->addColumn('aksi', function ($jenis) {
                // Tombol-tombol aksi (detail, edit, hapus) menggunakan modal
                $btn = '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->id . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->id . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->id . '/delete') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // Agar HTML tombol bisa dirender
            ->make(true); // Mengembalikan response JSON
    }

    // Menampilkan halaman form tambah jenis kendaraan
    public function create()
    {
        return view('jenis.create'); // Menampilkan form tambah jenis
    }

    // Menyimpan data jenis baru ke database
    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name' => 'required|string|min:3',
                'type' => 'required|string|min:3'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // Jika validasi gagal, kirim response error
                return response()->json(['status' => false, 'message' => 'Validasi Gagal', 'msgField' => $validator->errors()]);
            }

            // Ambil ID terakhir dari tabel jenis
            $lastJenis = Jenis::orderBy('id', 'desc')->first();
            // Tentukan ID baru secara manual (karena tidak auto-increment)
            $newId = $lastJenis ? $lastJenis->id + 1 : 1;

            // Tambahkan ID baru ke data yang dikirim
            $data = $request->all();
            $data['id'] = $newId;

            // Simpan data ke tabel jenis
            Jenis::create($data);

            return response()->json(['status' => true, 'message' => 'Data jenis berhasil disimpan']);
        }

        return redirect('/'); // Jika bukan AJAX, redirect ke halaman utama
    }

    // Menampilkan detail data jenis berdasarkan ID
    public function show(string $id)
    {
        $jenis = Jenis::find($id);
        $page = (object) [
            'title' => 'Detail Jenis'
        ];
        return view('jenis.show', compact('jenis', 'page'));
    }

    // Menampilkan form edit data jenis berdasarkan ID
    public function edit(string $id)
    {
        $jenis = Jenis::find($id);
        return view('jenis.edit', ['jenis' => $jenis]); // Menampilkan form edit jenis
    }

    // Menyimpan perubahan data jenis ke database
    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name' => 'required|string|min:3',
                'type' => 'required|string|min:3'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // Jika validasi gagal
                return response()->json(['status' => false, 'message' => 'Validasi gagal.', 'msgField' => $validator->errors()]);
            }

            $jenis = Jenis::find($id);
            if ($jenis) {
                // Jika data ditemukan, update
                $jenis->update($request->all());
                return response()->json(['status' => true, 'message' => 'Data berhasil diupdate']);
            }

            // Jika data tidak ditemukan
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return redirect('/');
    }

    // Menampilkan halaman konfirmasi penghapusan
    public function confirm(string $id)
    {
        // Cek apakah ID valid (numerik)
        if (!is_numeric($id)) {
            return redirect('/jenis')->with('error', 'ID tidak valid');
        }

        // Ambil data berdasarkan ID
        $jenis = Jenis::find($id);

        if (!$jenis) {
            // Jika tidak ditemukan
            return redirect('/jenis')->with('error', 'Jenis tidak ditemukan');
        }

        // Tampilkan halaman konfirmasi
        return view('jenis.confirm', ['jenis' => $jenis]);
    }

    // Menghapus data jenis (dan relasi mobil jika ada)
    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $jenis = Jenis::find($id); // Cari data Jenis berdasarkan ID

            if (!$jenis) {
                return response()->json(['status' => false, 'message' => 'Jenis tidak ditemukan']);
            }

            try {
                // Hapus semua mobil yang berelasi dengan jenis ini
                $jenis->mobil()->delete();

                // Hapus jenis itu sendiri
                $jenis->delete();

                return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
            } catch (\Exception $e) {
                // Jika gagal menghapus
                return response()->json(['status' => false, 'message' => 'Gagal menghapus data: ' . $e->getMessage()]);
            }
        }

        // Jika bukan request AJAX
        return redirect('/jenis');
    }

}
