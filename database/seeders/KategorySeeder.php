<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategory_code' => 'ELEK', 'kategory_name' => 'Elektronik'],
            ['kategory_code' => 'FASH', 'kategory_name' => 'Fashion'],
            ['kategory_code' => 'FOOD', 'kategory_name' => 'Makanan'],
            ['kategory_code' => 'TOYS', 'kategory_name' => 'Mainan'],
            ['kategory_code' => 'HOME', 'kategory_name' => 'Perabotan'],
        ];

        DB::table('m_kategory')->insert($data);
    }
}
