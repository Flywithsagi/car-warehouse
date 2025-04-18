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
            'title' => 'Daftar Jenis',
            'list' => ['Home', 'Jenis']
        ];

        $page = (object) [
            'title' => 'Daftar jenis yang tersedia dalam sistem'
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
                $btn = '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('jenis.create_ajax');
    }

    public function store_ajax(Request $request)
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

            Jenis::create($request->all());
            return response()->json(['status' => true, 'message' => 'Data jenis berhasil disimpan']);
        }
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $jenis = Jenis::find($id);
        return view('jenis.edit_ajax', ['jenis' => $jenis]);
    }

    public function update_ajax(Request $request, $id)
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

    public function confirm_ajax(string $id)
    {
        $jenis = Jenis::find($id);
        return view('jenis.confirm_ajax', ['jenis' => $jenis]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $jenis = Jenis::find($id);
            if ($jenis) {
                $jenis->delete();
                return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
            }
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return redirect('/');
    }
}
