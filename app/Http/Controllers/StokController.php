<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokModel;
use App\Models\BarangModel;

class StokController extends Controller
{
    public function index()
    {
        $data['page'] = (object)['title' => 'Data Stok Barang'];
        $data['stok'] = StokModel::with('barang')->get();
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

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        StokModel::create($request->all());

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil ditambahkan.');
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

    public function destroy($id)
    {
        $stok = StokModel::find($id);
        if ($stok) {
            $stok->delete();
            return redirect()->route('stok.index')->with('success', 'Data stok berhasil dihapus.');
        }

        return redirect()->route('stok.index')->with('error', 'Data stok tidak ditemukan.');
    }
}
