<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            "title" => "Daftar Barang",
            "list" => ['Home', 'Barang']
        ];

        $page = (object) [
            "title" => "Daftar barang yang terdaftar dalam sistem"
        ];

        $activeMenu = 'barang';

        $barang = BarangModel::with('kategory')->get();
        $kategory = KategoryModel::all();

        return view('barang.index', compact('breadcrumb', 'page', 'barang', 'kategory', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $barang = BarangModel::with('kategory')->select('barang_id', 'barang_kode', 'barang_nama', 'kategory_id', 'harga_beli', 'harga_jual');

        if ($request->kategory_id) {
            $barang->where('kategory_id', $request->kategory_id);
        }

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('kategory.kategory_name', fn($item) => $item->kategory->kategory_name ?? '-')
            ->addColumn('harga_beli', fn($item) => number_format($item->harga_beli))
            ->addColumn('harga_jual', fn($item) => number_format($item->harga_jual))
            ->addColumn('aksi', function ($item) {
                $urlShow   = url('/barang/' . $item->barang_id . '/show_ajax');
                $urlEdit   = url('/barang/' . $item->barang_id . '/edit_ajax');
                $urlDelete = url('/barang/' . $item->barang_id . '/delete_ajax');
                return '
                    <button onclick="modalAction(\'' . $urlShow . '\')" class="btn btn-info btn-sm">Detail</button>
                    <button onclick="modalAction(\'' . $urlEdit . '\')" class="btn btn-warning btn-sm">Edit</button>
                    <button onclick="modalAction(\'' . $urlDelete . '\')" class="btn btn-danger btn-sm">Delete</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            "title" => "Tambah Barang",
            "list" => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            "title" => "Tambah barang baru"
        ];

        $activeMenu = 'barang';

        $kategory = KategoryModel::all();

        return view('barang.create', compact('breadcrumb', 'page', 'kategory', 'activeMenu'));
    }

    public function create_ajax()
    {
        $kategory = KategoryModel::all();
        return view('barang.create_ajax', compact('kategory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_kode' => 'required|unique:m_barang,barang_kode|max:10',
            'barang_nama' => 'required|max:100',
            'kategory_id' => 'required|exists:m_kategory,kategory_id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        BarangModel::create($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'barang_kode' => 'required|string|unique:m_barang,barang_kode|max:10',
                'barang_nama' => 'required|string|max:100',
                'kategory_id' => 'required|exists:m_kategory,kategory_id',
                'harga_beli' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()->toArray()
                ]);
            }

            BarangModel::create([
                'barang_kode' => $request->barang_kode,
                'barang_nama' => $request->barang_nama,
                'kategory_id' => $request->kategory_id,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Barang berhasil ditambahkan.'
            ]);
        }

        return redirect()->route('barang.index');
    }

    public function show($id)
    {
        $barang = BarangModel::with('kategory')->find($id);
        if (!$barang) {
            return redirect()->route('barang.index')->with('error', 'Barang tidak ditemukan.');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Barang'
        ];

        $activeMenu = 'barang';

        return view('barang.show', compact('breadcrumb', 'page', 'barang', 'activeMenu'));
    }

    public function show_detail_ajax($id)
    {
        $barang = BarangModel::with('kategory')->find($id);
        return view('barang.show_ajax', ['barang' => $barang]);
    }

    public function edit($id)
    {
        $barang = BarangModel::find($id);
        $kategory = KategoryModel::all();

        if (!$barang) {
            return redirect()->route('barang.index')->with('error', 'Barang tidak ditemukan.');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Barang'
        ];

        $activeMenu = 'barang';

        return view('barang.edit', compact('breadcrumb', 'page', 'barang', 'kategory', 'activeMenu'));
    }

    public function edit_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        $kategory = KategoryModel::select('kategory_id', 'kategory_name')->get();

        return view('barang.edit_ajax', compact('barang', 'kategory'));
    }

    public function update(Request $request, $id)
    {
        $barang = BarangModel::find($id);
        if (!$barang) {
            return redirect()->route('barang.index')->with('error', 'Barang tidak ditemukan.');
        }

        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'barang_kode'  => 'required|string|unique:m_barang,barang_kode,' . $id . ',barang_id',
                'barang_nama'  => 'required|string|max:100',
                'kategory_id'  => 'required|integer|exists:m_kategory,kategory_id',
                'harga_beli'   => 'required|numeric|min:0',
                'harga_jual'   => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data barang berhasil diperbarui'
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return redirect('/barang');
    }

    public function delete_ajax($id)
    {
        $barang = BarangModel::find($id);
        if ($barang) {
            $barang->delete();
            return response()->json([
                'status' => true,
                'message' => 'Barang berhasil dihapus.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Barang tidak ditemukan.'
        ]);
    }

    public function confirm_delete_ajax($id)
    {
        $barang = BarangModel::find($id);
        return view('barang.confirm_ajax', compact('barang'));
    }
    public function import()
    {
        return view('barang.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_barang' => ['required', 'file', 'mimes:xlsx,xls', 'max:1024'],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Failed',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_barang');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];

            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'kategory_id' => $value['A'],
                            'barang_kode' => $value['B'],
                            'barang_nama' => $value['C'],
                            'harga_beli'  => $value['D'],
                            'harga_jual'  => $value['E'],
                            'created_at'  => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    BarangModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data imported successfully'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'No data imported'
                ]);
            }
        }

        return redirect('/');
    }
}
