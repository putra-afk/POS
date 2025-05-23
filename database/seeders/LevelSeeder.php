<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['level_id' => 1, 'level_code' => 'ADM', 'level_name' => 'Administator'],
            ['level_id' => 2, 'level_code' => 'MNG', 'level_name' => 'Manager'],
            ['level_id' => 3, 'level_code' => 'STF', 'level_name' => 'Staff/Kasir'],
        ];
        DB::table('m_level')->insert($data);
    }
}
