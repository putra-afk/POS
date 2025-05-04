<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
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
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                $btn  = '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button>';
                return $btn;
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

    public function show_detail_ajax($id)
    {
        $level = LevelModel::find($id);

        if (!$level) {
            // Tetap kembalikan view untuk konsistensi modal meskipun data tidak ditemukan
            return response()->view('level.show_ajax', ['level' => null]);
        }

        return response()->view('level.show_ajax', compact('level'));
    }

    public function edit($level_id)
    {
        $level = LevelModel::find($level_id);

        if (!$level) {
            return redirect()->route('level.index')->with('error', 'Data level tidak ditemukan');
        }

        $breadcrumb = (object) [
            "title" => "Edit Level",
            "list" => ["Home", "Level", "Edit"]
        ];

        $page = (object) [
            "title" => "Form Edit Level"
        ];

        $activeMenu = "level";

        return view('level.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'level' => $level
        ]);
    }

    public function edit_ajax($level_id)
    {
        $level = LevelModel::find($level_id);

        return view('level.edit_ajax', compact('level'));
    }

    public function update_ajax(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'level_code' => 'required|max:10',
            'level_name' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ]);
        }

        $level = LevelModel::find($request->level_id);

        if (!$level) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ]);
        }

        $level->update([
            'level_code' => $request->level_code,
            'level_name' => $request->level_name
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate'
        ]);
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_name')->get();
        return view('level.create_ajax', compact('level'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_name' => 'required|string|max:100',
                'level_code' => 'required|string|max:50|unique:m_level,level_code',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            LevelModel::create([
                'level_name' => $request->level_name,
                'level_code' => $request->level_code
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan'
            ]);
        }

        return redirect()->route('level.index');
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

    public function confirm_delete_ajax($id)
    {
        $level = LevelModel::find($id);
        return view('level.confirm_ajax', compact('level'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $level = LevelModel::find($id);
            if ($level) {
                $level->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data level berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data level tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    public function destroy(string $id)
    {
        $check = LevelModel::find($id);
        if (!$check) { // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        try {
            LevelModel::destroy($id); // Hapus data user
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
