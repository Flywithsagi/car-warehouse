<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MobilController extends Controller
{
    public function index()
    {
        // Ambil semua data jenis untuk filter
        $jenis = Jenis::all();
        $breadcrumb = (object) [
            'title' => 'Daftar Mobil',
            'list' => ['Home', 'Mobil']
        ];

        $page = (object) [
            'title' => 'Daftar Mobil yang tersedia dalam sistem'
        ];

        $activeMenu = 'mobil';

        return view('mobil.index', compact('breadcrumb', 'page', 'activeMenu', 'jenis'));
    }


    public function list(Request $request)
    {
        // Ambil data mobil beserta relasi 'jenis'
        $mobil = Mobil::with('jenis')->select('id', 'kode_mobil', 'name', 'brand', 'year', 'quantity', 'jenis_id');

        // Jika ada pencarian berdasarkan jenis, filter data
        if ($request->has('search_jenis') && $request->search_jenis != '') {
            $mobil = $mobil->whereHas('jenis', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search_jenis . '%');
            });
        }

        return DataTables::of($mobil)
            ->addIndexColumn()
            ->addColumn('jenis', function ($mobil) {
                return $mobil->jenis->name ?? '-'; // Menampilkan nama jenis kendaraan
            })
            ->addColumn('aksi', function ($mobil) {
                $btn = '<button onclick="modalAction(\'' . url('/mobil/' . $mobil->id . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mobil/' . $mobil->id . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mobil/' . $mobil->id . '/delete') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function create()
    {
        $jenis = Jenis::all(); // Ambil semua data jenis kendaraan
        return view('mobil.create', compact('jenis')); // Menampilkan form tambah mobil
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name' => 'required|string|min:3',
                'brand' => 'required|string|min:3',
                'year' => 'required|integer|min:1900',
                'quantity' => 'required|integer|min:1',
                'jenis_id' => 'required|exists:jenis,id'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // Ambil ID terakhir, lalu +1 sebagai ID baru
            $lastId = Mobil::max('id') ?? 0;
            $newId = $lastId + 1;

            // Generate kode_mobil otomatis
            $lastMobil = Mobil::orderBy('id', 'desc')->first();
            $newCode = 'MB' . str_pad(
                ($lastMobil ? (intval(substr($lastMobil->kode_mobil, 2)) + 1) : 1),
                4,
                '0',
                STR_PAD_LEFT
            );

            // Buat data baru
            $mobil = new Mobil();
            $mobil->id = $newId; // Custom ID (non-auto-increment)
            $mobil->kode_mobil = $newCode;
            $mobil->name = $request->name;
            $mobil->brand = $request->brand;
            $mobil->year = $request->year;
            $mobil->quantity = $request->quantity;
            $mobil->jenis_id = $request->jenis_id;
            $mobil->save();

            return response()->json([
                'status' => true,
                'message' => 'Data mobil berhasil disimpan'
            ]);
        }

        return redirect('/');
    }


    public function show(string $id)
    {
        $mobil = Mobil::find($id);
        $jenis = Jenis::find($mobil->jenis_id); // Mengambil data jenis berdasarkan jenis_id di tabel mobil

        if (empty($jenis)) {
            // Jika jenis tidak ditemukan, kirim pesan kesalahan melalui with()
            return view('mobil.show', compact('mobil'))->with('error', 'Data jenis tidak ditemukan');
        }

        return view('mobil.show', compact('mobil', 'jenis'));
    }

    // Controller: MobilController.php

    public function edit(string $id)
    {
        $mobil = Mobil::find($id);
        $listJenis = Jenis::all(); // Ambil semua jenis untuk dropdown
        return view('mobil.edit', compact('mobil', 'listJenis'));
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name' => 'required|string|min:3',
                'brand' => 'required|string|min:3',
                'year' => 'required|integer|min:1900',
                'quantity' => 'required|integer|min:1',
                'jenis_id' => 'required|exists:jenis,id',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $mobil = Mobil::find($id);
            if (!$mobil) {
                return response()->json(['status' => false, 'message' => 'Data mobil tidak ditemukan']);
            }

            $mobil->update($request->all());

            return response()->json(['status' => true, 'message' => 'Data mobil berhasil diperbarui']);
        }

        return redirect('/');
    }

    public function confirm(string $id)
    {
        // Cek apakah ID valid
        if (!is_numeric($id)) {
            return redirect('/mobil')->with('error', 'ID tidak valid');
        }

        // Ambil data mobil berdasarkan ID
        $mobil = Mobil::find($id);

        if (!$mobil) {
            // Jika data mobil tidak ditemukan, redirect ke halaman lain atau tampilkan pesan kesalahan
            return redirect('/mobil')->with('error', 'Mobil tidak ditemukan');
        }

        // Mengembalikan view dengan data mobil untuk konfirmasi penghapusan
        return view('mobil.confirm', ['mobil' => $mobil]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mobil = Mobil::find($id); // Cari data Mobil berdasarkan ID

            if (!$mobil) {
                return response()->json(['status' => false, 'message' => 'Mobil tidak ditemukan']); // Jika data Mobil tidak ditemukan
            }

            try {
                // Hapus data mobil
                $mobil->delete();

                return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']); // Jika berhasil dihapus
            } catch (\Exception $e) {
                // Menangkap kesalahan yang terjadi selama proses penghapusan
                return response()->json(['status' => false, 'message' => 'Gagal menghapus data: ' . $e->getMessage()]);
            }
        }

        // Jika bukan request AJAX, redirect ke halaman lain
        return redirect('/mobil');
    }
}
