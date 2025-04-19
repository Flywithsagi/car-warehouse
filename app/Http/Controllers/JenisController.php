<?php
namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class JenisController extends Controller
{
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

    public function list(Request $request)
    {
        $jenis = Jenis::select('id', 'name', 'type');

        return DataTables::of($jenis)
            ->addIndexColumn()
            ->addColumn('aksi', function ($jenis) {
                $btn = '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->id . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->id . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->id . '/delete') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true); // Response dalam format JSON
    }

    public function create()
    {
        return view('jenis.create'); // Menampilkan form tambah jenis
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name' => 'required|string|min:3',
                'type' => 'required|string|min:3'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validasi Gagal', 'msgField' => $validator->errors()]);
            }

            // Ambil ID terakhir
            $lastJenis = Jenis::orderBy('id', 'desc')->first();
            // Auto-generate ID untuk jenis baru
            $newId = $lastJenis ? $lastJenis->id + 1 : 1; // Mulai dari 1 jika data kosong

            // Menambahkan ID yang di-generate ke request
            $data = $request->all();
            $data['id'] = $newId; // Assign ID baru

            // Simpan data jenis
            Jenis::create($data);

            return response()->json(['status' => true, 'message' => 'Data jenis berhasil disimpan']);
        }

        return redirect('/');
    }


    public function show(string $id)
    {
        $jenis = Jenis::find($id);
        $page = (object) [
            'title' => 'Detail Jenis'
        ];
        return view('jenis.show', compact('jenis', 'page'));
    }

    public function edit(string $id)
    {
        $jenis = Jenis::find($id);
        return view('jenis.edit', ['jenis' => $jenis]); // Menampilkan form edit jenis
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name' => 'required|string|min:3',
                'type' => 'required|string|min:3'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validasi gagal.', 'msgField' => $validator->errors()]);
            }

            $jenis = Jenis::find($id);
            if ($jenis) {
                $jenis->update($request->all());
                return response()->json(['status' => true, 'message' => 'Data berhasil diupdate']);
            }

            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return redirect('/');
    }

    public function confirm(string $id)
    {
        // Cek apakah ID valid
        if (!is_numeric($id)) {
            return redirect('/jenis')->with('error', 'ID tidak valid');
        }

        // Ambil data jenis berdasarkan ID
        $jenis = Jenis::find($id);

        if (!$jenis) {
            // Jika data jenis tidak ditemukan, redirect ke halaman lain atau tampilkan pesan kesalahan
            return redirect('/jenis')->with('error', 'Jenis tidak ditemukan');
        }

        // Mengembalikan view dengan data jenis untuk konfirmasi penghapusan
        return view('jenis.confirm', ['jenis' => $jenis]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $jenis = Jenis::find($id); // Cari data Jenis berdasarkan ID

            if (!$jenis) {
                return response()->json(['status' => false, 'message' => 'Jenis tidak ditemukan']); // Jika data Jenis tidak ditemukan
            }

            try {
                // Hapus mobil yang berelasi dengan jenis
                $jenis->mobil()->delete(); // Menghapus semua mobil yang memiliki jenis_id yang sama

                // Hapus data jenis
                $jenis->delete();

                return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']); // Jika berhasil dihapus
            } catch (\Exception $e) {
                // Menangkap kesalahan yang terjadi selama proses penghapusan
                return response()->json(['status' => false, 'message' => 'Gagal menghapus data: ' . $e->getMessage()]);
            }
        }

        // Jika bukan request AJAX, redirect ke halaman lain
        return redirect('/jenis');
    }

}
