<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class kategoryController extends Controller
{
    public function index()
    {
        /*$data = [
            'kategory_code' => 'SNK',
            'kategory_name' => 'Snack/Makanan Ringan',
            'created_at' => now()
        ];

        DB::table('m_kategory')->insert($data);

        return 'Insert data baru berhasil!';
        */

        /*$row = DB::table('m_kategory')
            ->where('kategory_code', 'SNK')
            ->update(['kategory_name' => 'Camilan']);

        return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';
        */

        /*$row = DB::table('m_kategory')->where('kategory_code', 'SNK')->delete();
        return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';
        */

        $data = DB::table('m_kategory')->get();
        return view('kategory', ['data' => $data]);
    }
}
