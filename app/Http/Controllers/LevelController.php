<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            "title" => "Daftar Level",
            "list" => ['Home', 'Level']
        ];

        $page = (object) [
            "title" => "Daftar level dalam sistem"
        ];

        $activeMenu = 'level';

        $levels = LevelModel::all();

        return view('level.index_level', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'levels' => $levels
        ]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            "title" => "Tambah Level",
            "list" => ["Home", "Level", "Tambah"]
        ];

        $page = (object) [
            "title" => "Tambah level baru"
        ];

        $activeMenu = "level";

        return view('level.create_level', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $levels = LevelModel::select(['level_id', 'level_name', 'level_code']);

            return DataTables::of($levels)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return '<a href="/level/edit/' . $row->level_id . '" class="btn btn-warning btn-sm">Edit</a>
                            <a href="/level/delete/' . $row->level_id . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus?\')">Hapus</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_name' => 'required|string|max:100',
            'level_code' => 'required|string|max:50|unique:m_level,level_code'
        ]);

        LevelModel::create([
            'level_name' => $request->level_name,
            'level_code' => $request->level_code
        ]);

        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }

    public function show(string $id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail level'
        ];

        $activeMenu = 'level';

        return view('level.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit(string $id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Level'
        ];

        $activeMenu = 'level';

        return view('level.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'level_name' => 'required|string|max:100',
            'level_code' => 'required|string|max:50|unique:m_level,level_code,' . $id . ',level_id'
        ]);

        LevelModel::find($id)->update([
            'level_name' => $request->level_name,
            'level_code' => $request->level_code
        ]);

        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = LevelModel::find($id);
        if (!$check) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        try {
            LevelModel::destroy($id);
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
