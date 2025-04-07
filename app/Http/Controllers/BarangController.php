<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KategoryModel;


class BarangController extends Controller
{
    public function index()
    {
        $data['page'] = (object)[
            'title' => 'Data Barang'
        ];

        $data['barang'] = BarangModel::with('kategory')->get();
        $data['activeMenu'] = 'barang';

        return view('barang.index', $data);
    }

    public function create()
    {
        $data['page'] = (object)[
            'title' => 'Tambah Barang'
        ];

        $data['kategory'] = KategoryModel::all();
        $data['activeMenu'] = 'barang';

        return view('barang.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_kode' => 'required',
            'barang_nama' => 'required',
            'kategory_id' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);

        BarangModel::create($request->all());

        return redirect()->route('barang.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $data['barang'] = BarangModel::with('kategory')->find($id);

        if (!$data['barang']) {
            return redirect()->route('barang.index')->with('error', 'Data tidak ditemukan.');
        }

        $data['page'] = (object)[
            'title' => 'Detail Barang'
        ];
        $data['activeMenu'] = 'barang';

        return view('barang.show', $data);
    }

    public function edit($id)
    {
        $data['barang'] = BarangModel::find($id);
        $data['kategory'] = KategoryModel::all();

        if (!$data['barang']) {
            return redirect()->route('barang.index')->with('error', 'Data tidak ditemukan.');
        }

        $data['page'] = (object)[
            'title' => 'Edit Barang'
        ];
        $data['activeMenu'] = 'barang';

        return view('barang.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $barang = BarangModel::find($id);

        if (!$barang) {
            return redirect()->route('barang.index')->with('error', 'Data tidak ditemukan.');
        }

        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = BarangModel::find($id);

        if ($barang) {
            $barang->delete();
            return redirect()->route('barang.index')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->route('barang.index')->with('error', 'Data tidak ditemukan.');
    }
}
