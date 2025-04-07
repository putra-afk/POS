<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KategoryModel;
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
                return '<a href="' . route('kategory.edit', $kategory->kategory_id) . '" class="btn btn-warning btn-sm">Edit</a>
                <form action="' . route('kategory.destroy', $kategory->kategory_id) . '" method="POST" style="display:inline;">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>';
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

    public function destroy(string $kategory_id)
    {
        $kategory = KategoryModel::find($kategory_id);

        if (!$kategory) {
            return redirect('/kategory')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            $kategory->delete();
            return redirect('/kategory')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategory')->with('error', 'Data kategori gagal dihapus karena masih terdapat data terkait');
        }
    }
}
