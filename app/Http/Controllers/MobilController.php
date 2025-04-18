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
        $breadcrumb = (object) [
            'title' => 'Daftar Mobil',
            'list' => ['Home', 'Mobil']
        ];

        $page = (object) [
            'title' => 'Daftar mobil yang tersedia dalam sistem'
        ];

        $activeMenu = 'mobil';

        return view('mobil.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $mobil = Mobil::with('jenis')->select('id', 'name', 'brand', 'year', 'quantity', 'jenis_id');

        return DataTables::of($mobil)
            ->addIndexColumn()
            ->addColumn('jenis', function ($mobil) {
                return $mobil->jenis->name ?? '-';
            })
            ->addColumn('aksi', function ($mobil) {
                $btn = '<button onclick="modalAction(\'' . url('/mobil/' . $mobil->id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mobil/' . $mobil->id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mobil/' . $mobil->id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $jenis = Jenis::all(); // Mengambil data jenis untuk dropdown
        return view('mobil.create_ajax', compact('jenis'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name' => 'required|string|min:3',
                'brand' => 'required|string|min:3',
                'year' => 'required|integer',
                'quantity' => 'required|integer',
                'jenis_id' => 'required|exists:jenis,id' // Validasi untuk memastikan 'jenis_id' ada di tabel 'jenis'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validasi Gagal', 'msgField' => $validator->errors()]);
            }

            Mobil::create($request->all());
            return response()->json(['status' => true, 'message' => 'Data mobil berhasil disimpan']);
        }
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $mobil = Mobil::find($id);
        $jenis = Jenis::all(); // Mengambil data jenis untuk dropdown
        return view('mobil.edit_ajax', compact('mobil', 'jenis'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name' => 'required|string|min:3',
                'brand' => 'required|string|min:3',
                'year' => 'required|integer',
                'quantity' => 'required|integer',
                'jenis_id' => 'required|exists:jenis,id' // Validasi untuk memastikan 'jenis_id' ada di tabel 'jenis'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validasi gagal.', 'msgField' => $validator->errors()]);
            }

            $mobil = Mobil::find($id);
            if ($mobil) {
                $mobil->update($request->all());
                return response()->json(['status' => true, 'message' => 'Data berhasil diupdate']);
            }

            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $mobil = Mobil::find($id);
        return view('mobil.confirm_ajax', ['mobil' => $mobil]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mobil = Mobil::find($id);
            if ($mobil) {
                $mobil->delete();
                return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
            }
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return redirect('/');
    }
}
