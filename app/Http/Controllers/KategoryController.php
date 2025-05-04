<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KategoryModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class KategoryController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            "title" => "Daftar Kategori",
            "list" => ['Home', 'Kategori']
        ];

        $page = (object) [
            "title" => "Daftar kategori yang terdaftar dalam sistem"
        ];

        $activeMenu = 'kategory';

        $kategories = KategoryModel::all();

        return view('kategory.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategories' => $kategories,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $query = KategoryModel::select('kategory_id', 'kategory_name', 'kategory_code');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategory) {
                $btn  = '<button onclick="modalAction(\'' . url('/kategory/' . $kategory->kategory_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategory/' . $kategory->kategory_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategory/' . $kategory->kategory_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button>';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            "title" => "Tambah Kategori",
            "list" => ["Home", "Kategori Tambah"]
        ];

        $page = (object) [
            "title" => "Tambah kategori baru"
        ];

        $activeMenu = "kategory";

        return view('kategory.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategory_code' => 'required|unique:m_kategory,kategory_code|max:10',
            'kategory_name' => 'required|max:100',
        ]);

        KategoryModel::create([
            'kategory_code' => $request->kategory_code,
            'kategory_name' => $request->kategory_name
        ]);

        return redirect()->route('kategory.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function create_ajax()
    {
        return view('kategory.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategory_name' => 'required|string|max:100',
                'kategory_code' => 'required|string|max:10|unique:m_kategory,kategory_code',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            KategoryModel::create([
                'kategory_name' => $request->kategory_name,
                'kategory_code' => $request->kategory_code
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil disimpan'
            ]);
        }

        return redirect()->route('kategory.index');
    }

    public function show($kategory_id)
    {
        $kategory = KategoryModel::find($kategory_id);

        if (!$kategory) {
            return redirect('/kategory')->with('error', 'Data kategori tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Kategori'
        ];

        $activeMenu = 'kategory';

        return view('kategory.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategory' => $kategory,
            'activeMenu' => $activeMenu
        ]);
    }

    public function show_detail_ajax($id)
    {
        $kategory = KategoryModel::find($id);

        if (!$kategory) {
            // Tetap kembalikan view untuk konsistensi modal meskipun data tidak ditemukan
            return response()->view('kategory.show_ajax', ['kategory' => null]);
        }

        return response()->view('kategory.show_ajax', compact('kategory'));
    }

    public function edit_ajax($kategory_id)
    {
        $kategory = KategoryModel::find($kategory_id);

        return view('kategory.edit_ajax', compact('kategory'));
    }

    public function update_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategory_code' => 'required|max:20',
            'kategory_name' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ]);
        }

        $kategory = KategoryModel::find($request->kategory_id);

        if (!$kategory) {
            return response()->json([
                'status' => false,
                'message' => 'Data kategori tidak ditemukan.'
            ]);
        }

        $kategory->update([
            'kategory_code' => $request->kategory_code,
            'kategory_name' => $request->kategory_name
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data kategori berhasil diupdate.'
        ]);
    }


    public function edit($id)
    {
        $kategory = KategoryModel::find($id);

        if (!$kategory) {
            return redirect()->route('kategory.index')->with('error', 'Data kategori tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Data Kategori'
        ];

        $activeMenu = 'kategory';

        return view('kategory.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategory' => $kategory,
            'activeMenu' => $activeMenu
        ]);
    }


    public function update(Request $request, string $kategory_id)
    {
        $request->validate([
            'kategory_name' => 'required|string|min:3|unique:m_kategory,kategory_name,' . $kategory_id . ',kategory_id',
            'kategory_code' => 'required|string|max:100'
        ]);

        $kategory = KategoryModel::find($kategory_id);

        if (!$kategory) {
            return redirect('/kategory')->with('error', 'Data kategori tidak ditemukan');
        }

        $kategory->update([
            'kategory_name' => $request->kategory_name,
            'kategory_code' => $request->kategory_code
        ]);

        return redirect('/kategory')->with('success', 'Data kategori berhasil diubah');
    }

    public function confirm_delete_ajax($id)
    {
        $kategory = KategoryModel::find($id);
        return view('kategory.confirm_ajax', compact('kategory'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kategory = KategoryModel::find($id);
            if ($kategory) {
                $kategory->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data kategori berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data kategori tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    public function destroy(string $id)
    {
        $check = KategoryModel::find($id);
        if (!$check) { // untuk mengecek apakah data kategory dengan id yang dimaksud ada atau tidak
            return redirect('/kategory')->with('error', 'Data kategory tidak ditemukan');
        }

        try {
            KategoryModel::destroy($id); // Hapus data kategory
            return redirect('/kategory')->with('success', 'Data kategory berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/kategory')->with('error', 'Data kategory gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
