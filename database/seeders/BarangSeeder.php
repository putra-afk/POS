<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategory_id' => 1, 'barang_kode' => 'TV01', 'barang_nama' => 'TV LED 32 Inch', 'harga_beli' => 2000000, 'harga_jual' => 2500000],
            ['kategory_id' => 1, 'barang_kode' => 'HP01', 'barang_nama' => 'Smartphone Android', 'harga_beli' => 3000000, 'harga_jual' => 3500000],
            ['kategory_id' => 2, 'barang_kode' => 'TSH1', 'barang_nama' => 'Kaos Polos', 'harga_beli' => 50000, 'harga_jual' => 75000],
            ['kategory_id' => 2, 'barang_kode' => 'JNS1', 'barang_nama' => 'Celana Jeans', 'harga_beli' => 150000, 'harga_jual' => 200000],
            ['kategory_id' => 3, 'barang_kode' => 'MIE1', 'barang_nama' => 'Mie Instan', 'harga_beli' => 2500, 'harga_jual' => 3000],
            ['kategory_id' => 3, 'barang_kode' => 'SUS1', 'barang_nama' => 'Susu Kotak', 'harga_beli' => 5000, 'harga_jual' => 7000],
            ['kategory_id' => 4, 'barang_kode' => 'CAR1', 'barang_nama' => 'Mobil Mainan', 'harga_beli' => 50000, 'harga_jual' => 75000],
            ['kategory_id' => 4, 'barang_kode' => 'DOL1', 'barang_nama' => 'Boneka', 'harga_beli' => 40000, 'harga_jual' => 60000],
            ['kategory_id' => 5, 'barang_kode' => 'TB01', 'barang_nama' => 'Meja Kayu', 'harga_beli' => 500000, 'harga_jual' => 600000],
            ['kategory_id' => 5, 'barang_kode' => 'KR01', 'barang_nama' => 'Kursi Plastik', 'harga_beli' => 30000, 'harga_jual' => 45000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
