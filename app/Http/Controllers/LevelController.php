<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            "title" => "Daftar Level",
            "list" => ['Home', 'Level']
        ];

        $page = (object) [
            "title" => "Daftar level yang terdaftar dalam sistem"
        ];

        $activeMenu = 'level';

        $levels = LevelModel::all();

        return view('level.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'levels' => $levels,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $query = LevelModel::select('level_id', 'level_name', 'level_code');

        return DataTables::of($query)
            ->addIndexColumn() // ✅ Fix: Adds DT_RowIndex automatically
            ->addColumn('aksi', function ($level) {
                return '<a href="' . route('level.edit', $level->level_id) . '" class="btn btn-warning btn-sm">Edit</a>
                <form action="' . route('level.destroy', $level->level_id) . '" method="POST" style="display:inline;">
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
            "title" => "Tambah Level",
            "list" => ["Home", "Level Tambah"]
        ];

        $page = (object) [
            "title" => "Tambah Level baru"
        ];

        $activeMenu = "level";

        return view('level.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_code' => 'required|unique:m_level,level_code|max:10',
            'level_name' => 'required|max:100',
        ]);

        LevelModel::create([
            'level_code' => $request->level_code,
            'level_name' => $request->level_name
        ]);

        return redirect()->route('level.index')->with('success', 'Level berhasil ditambahkan!');
    }

    public function show($level_id)
    {
        // Debugging: Check if the ID is being received
        $level = LevelModel::find($level_id);

        if (!$level) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Level'
        ];

        $activeMenu = 'level';

        return view('level.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }


    public function update(Request $request, string $level_id)
    {
        $request->validate([
            'level_name' => 'required|string|min:3|unique:m_level,level_name,' . $level_id . ',level_id',
            'level_code' => 'required|string|max:100'
        ]);

        $level = LevelModel::find($level_id);

        if (!$level) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        $level->update([
            'level_name' => $request->level_name,
            'level_code' => $request->level_code
        ]);

        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }

    public function destroy(string $level_id)
    {
        $level = LevelModel::find($level_id);

        if (!$level) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        try {
            $level->delete();
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat data terkait');
        }
    }
}
