<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        if (Kelas::count() == 0) {
            # code...
            Kelas::insert([
                [
                    'ting' => '3',
                    'nama_kelas' => 'HIKMAH',
                ],
                [
                    'ting' => '3',
                    'nama_kelas' => 'ASPIRASI',
                ],
                [
                    'ting' => '3',
                    'nama_kelas' => 'DINAMIK',
                ],
                [
                    'ting' => '4',
                    'nama_kelas' => 'EFEKTIF',
                ],
                [
                    'ting' => '5',
                    'nama_kelas' => 'FITRAH',
                ],
                [
                    'ting' => '6',
                    'nama_kelas' => 'DINAMIK',
                ],
            ]);
        } else {
            echo "\e[31mTable is not empty, therefore NOT ";
        }
    }
}
