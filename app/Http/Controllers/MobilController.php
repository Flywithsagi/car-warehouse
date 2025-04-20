<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MobilController extends Controller
{
    // Menampilkan halaman utama daftar mobil
    public function index()
    {
        // Ambil semua data jenis untuk keperluan filter dropdown
        $jenis = Jenis::all();

        // Breadcrumb untuk navigasi halaman
        $breadcrumb = (object) [
            'title' => 'Daftar Mobil',
            'list' => ['Home', 'Mobil']
        ];

        // Judul halaman
        $page = (object) [
            'title' => 'Daftar Mobil yang tersedia dalam sistem'
        ];

        // Menentukan menu aktif
        $activeMenu = 'mobil';

        // Mengembalikan view halaman index mobil dengan data terkait
        return view('mobil.index', compact('breadcrumb', 'page', 'activeMenu', 'jenis'));
    }

    // Mengambil data mobil dalam format JSON untuk DataTables
    public function list(Request $request)
    {
        // Ambil data mobil beserta relasi jenis
        $mobil = Mobil::with('jenis')->select('id', 'kode_mobil', 'name', 'brand', 'year', 'quantity', 'jenis_id');

        // Filter berdasarkan nama jenis kendaraan jika ada permintaan filter
        if ($request->has('search_jenis') && $request->search_jenis != '') {
            $mobil = $mobil->whereHas('jenis', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search_jenis . '%');
            });
        }

        // Konversi data ke format DataTables
        return DataTables::of($mobil)
            ->addIndexColumn()
            ->addColumn('jenis', function ($mobil) {
                return $mobil->jenis->name ?? '-'; // Menampilkan nama jenis, atau '-' jika tidak ada
            })
            ->addColumn('aksi', function ($mobil) {
                // Tombol aksi (detail, edit, hapus) dengan pemanggilan modal
                $btn = '<button onclick="modalAction(\'' . url('/mobil/' . $mobil->id . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mobil/' . $mobil->id . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mobil/' . $mobil->id . '/delete') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // Memastikan kolom aksi dirender sebagai HTML
            ->make(true);
    }

    // Menampilkan form tambah data mobil
    public function create()
    {
        $jenis = Jenis::all(); // Ambil semua jenis kendaraan untuk dropdown
        return view('mobil.create', compact('jenis')); // Kembalikan form create mobil
    }

    // Menyimpan data mobil baru ke database
    // Menyimpan data mobil baru ke database
    public function store(Request $request)
    {
        // Cek apakah request berasal dari AJAX
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi data input
            $rules = [
                'name' => 'required|string|min:3',
                'brand' => 'required|string|min:3',
                'year' => 'required|integer|min:1900',
                'quantity' => 'required|integer|min:1',
                'jenis_id' => 'required|exists:jenis,id'
            ];

            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal, kirimkan response error
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // Cek apakah mobil dengan nama, merek, dan tahun yang sama sudah ada
            $existingMobil = Mobil::where('name', $request->name)
                ->where('brand', $request->brand)
                ->where('year', $request->year)
                ->first();

            if ($existingMobil) {
                // Jika sudah ada, tambahkan quantity-nya
                $existingMobil->quantity += $request->quantity;
                $existingMobil->save();

                // Response sukses
                return response()->json([
                    'status' => true,
                    'message' => 'Data mobil berhasil diperbarui (quantity ditambahkan)'
                ]);
            } else {
                // Ambil ID terakhir dari tabel mobil
                $lastId = Mobil::max('id') ?? 0;
                $newId = $lastId + 1;

                // Auto generate kode mobil (contoh: MB0001)
                $lastMobil = Mobil::orderBy('id', 'desc')->first();
                $newCode = 'MB' . str_pad(
                    ($lastMobil ? (intval(substr($lastMobil->kode_mobil, 2)) + 1) : 1),
                    4,
                    '0',
                    STR_PAD_LEFT
                );

                // Simpan data mobil baru ke database
                $mobil = new Mobil();
                $mobil->id = $newId;
                $mobil->kode_mobil = $newCode;
                $mobil->name = $request->name;
                $mobil->brand = $request->brand;
                $mobil->year = $request->year;
                $mobil->quantity = $request->quantity;
                $mobil->jenis_id = $request->jenis_id;
                $mobil->save();

                // Response sukses
                return response()->json([
                    'status' => true,
                    'message' => 'Data mobil berhasil disimpan'
                ]);
            }
        }

        return redirect('/');
    }

    // Menampilkan detail mobil berdasarkan ID
    public function show(string $id)
    {
        $mobil = Mobil::find($id);
        $jenis = Jenis::find($mobil->jenis_id); // Ambil data jenis berdasarkan jenis_id dari mobil

        // Jika jenis tidak ditemukan, tampilkan error
        if (empty($jenis)) {
            return view('mobil.show', compact('mobil'))->with('error', 'Data jenis tidak ditemukan');
        }

        return view('mobil.show', compact('mobil', 'jenis'));
    }

    // Menampilkan form edit mobil
    public function edit(string $id)
    {
        $mobil = Mobil::find($id);
        $listJenis = Jenis::all(); // Ambil semua jenis untuk dropdown
        return view('mobil.edit', compact('mobil', 'listJenis'));
    }

    // Menyimpan pembaruan data mobil
    public function update(Request $request, $id)
    {
        // Cek apakah request berasal dari AJAX
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi data
            $rules = [
                'name' => 'required|string|min:3',
                'brand' => 'required|string|min:3',
                'year' => 'required|integer|min:1900',
                'quantity' => 'required|integer|min:1',
                'jenis_id' => 'required|exists:jenis,id',
            ];

            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal, kirimkan pesan error
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            // Cari mobil berdasarkan ID
            $mobil = Mobil::find($id);
            if (!$mobil) {
                return response()->json(['status' => false, 'message' => 'Data mobil tidak ditemukan']);
            }

            // Update data mobil
            $mobil->update($request->all());

            return response()->json(['status' => true, 'message' => 'Data mobil berhasil diperbarui']);
        }

        return redirect('/');
    }

    // Menampilkan halaman konfirmasi penghapusan mobil
    public function confirm(string $id)
    {
        // Validasi ID numerik
        if (!is_numeric($id)) {
            return redirect('/mobil')->with('error', 'ID tidak valid');
        }

        // Cari data mobil berdasarkan ID
        $mobil = Mobil::find($id);

        // Jika data tidak ditemukan
        if (!$mobil) {
            return redirect('/mobil')->with('error', 'Mobil tidak ditemukan');
        }

        // Tampilkan halaman konfirmasi penghapusan
        return view('mobil.confirm', ['mobil' => $mobil]);
    }

    // Menghapus data mobil dari database
    public function delete(Request $request, $id)
    {
        // Cek apakah request AJAX
        if ($request->ajax() || $request->wantsJson()) {
            // Cari mobil berdasarkan ID
            $mobil = Mobil::find($id);

            // Jika tidak ditemukan
            if (!$mobil) {
                return response()->json(['status' => false, 'message' => 'Mobil tidak ditemukan']);
            }

            try {
                // Hapus data mobil
                $mobil->delete();

                return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
            } catch (\Exception $e) {
                // Jika terjadi error saat menghapus
                return response()->json(['status' => false, 'message' => 'Gagal menghapus data: ' . $e->getMessage()]);
            }
        }

        // Redirect jika bukan AJAX
        return redirect('/mobil');
    }
}
