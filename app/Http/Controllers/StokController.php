<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokModel;
use App\Models\BarangModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
        $data['page'] = (object)['title' => 'Data Stok Barang'];
        $data['stoks'] = StokModel::with('barang')->get();
        $data['barang'] = BarangModel::all();
        $data['activeMenu'] = 'stok';

        return view('stok.index', $data);
    }

    public function create()
    {
        $data['page'] = (object)['title' => 'Tambah Stok Barang'];
        $data['barang'] = BarangModel::all();
        $data['activeMenu'] = 'stok';

        return view('stok.create', $data);
    }

    public function create_ajax()
    {
        $barang = BarangModel::all();
        return view('stok.create_ajax', compact('barang'));
    }

    public function show($id)
    {
        $stok = StokModel::with('barang')->find($id);
        if (!$stok) {
            return redirect()->route('stok.index')->with('error', 'Data tidak ditemukan.');
        }

        $data['page'] = (object)['title' => 'Detail Stok Barang'];
        $data['stok'] = $stok;
        $data['activeMenu'] = 'stok';

        return view('stok.show', $data);
    }

    public function show_detail_ajax($id)
    {
        $stok = StokModel::with('barang')->find($id);

        if (!$stok) {
            return response()->view('stok.show_ajax', ['stok' => null]);
        }

        return response()->view('stok.show_ajax', compact('stok'));
    }

    public function list(Request $request)
    {
        $query = StokModel::with('barang')
            ->select('stok_id', 'barang_id', 'stok_jumlah', 'stok_tanggal', 'user_id');

        if ($request->barang_id) {
            $query->where('barang_id', $request->barang_id);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('barang_nama', function ($stok) {
                return $stok->barang ? $stok->barang->barang_nama : '-';
            })
            ->addColumn('aksi', function ($stok) {
                $btn  = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button>';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id'    => 'required|exists:m_barang,barang_id',
                'stok_jumlah'  => 'required|integer|min:1',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi gagal',
                    'msgField'  => $validator->errors()
                ]);
            }

            StokModel::create([
                'barang_id'    => $request->barang_id,
                'stok_jumlah'  => $request->stok_jumlah,
                'stok_tanggal' => now(),
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Data stok berhasil disimpan'
            ]);
        }

        return redirect()->route('stok.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'stok_jumlah' => 'required|numeric|min:1',
        ]);

        $userId = auth()->id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'You must be logged in to add stock.');
        }

        StokModel::create([
            'barang_id' => $request->barang_id,
            'user_id' => $userId,
            'stok_tanggal' => now()->format('Y-m-d'),
            'stok_jumlah' => $request->stok_jumlah,
        ]);

        return redirect()->route('stok.index')->with('success', 'Data Stok berhasil disimpan');
    }

    public function edit($id)
    {
        $stok = StokModel::find($id);
        if (!$stok) {
            return redirect()->route('stok.index')->with('error', 'Data tidak ditemukan.');
        }

        $data['page'] = (object)['title' => 'Edit Stok Barang'];
        $data['stok'] = $stok;
        $data['barang'] = BarangModel::all();
        $data['activeMenu'] = 'stok';

        return view('stok.edit', $data);
    }

    public function edit_ajax($id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::all();

        return response()->view('stok.edit_ajax', compact('stok', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $stok = StokModel::find($id);
        if (!$stok) {
            return redirect()->route('stok.index')->with('error', 'Data tidak ditemukan.');
        }

        $request->validate([
            'barang_id' => 'required',
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $stok->update($request->all());

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil diperbarui.');
    }

    public function update_ajax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'barang_id'     => 'required|exists:m_barang,barang_id',
            'stok_jumlah'   => 'required|numeric|min:0',
            'keterangan'    => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors(),
            ]);
        }

        $stok = StokModel::find($id);

        if (!$stok) {
            return response()->json([
                'status' => false,
                'message' => 'Data stok tidak ditemukan!',
            ]);
        }

        $stok->update([
            'barang_id'     => $request->barang_id,
            'stok_jumlah'   => $request->stok_jumlah,
            'keterangan'    => $request->keterangan,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data stok berhasil diperbarui.',
        ]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);
            if ($stok) {
                $stok->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data stok tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    public function confirm_delete_ajax($id)
    {
        $stok = StokModel::find($id);
        return view('stok.confirm_ajax', compact('stok'));
    }

    public function destroy(string $id)
    {
        $check = StokModel::find($id);
        if (!$check) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            StokModel::destroy($id);
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
