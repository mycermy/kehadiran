<?php

namespace Database\Seeders;

use App\Models\Ahli;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AhliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        if (Ahli::count() == 0) {
            # code...
            Ahli::insert([
                [
                    'kelas_id' => 1,
                    'nama' => 'Anisa',
                    'nokp' => '123456789101',
                    'tahap' => 'ADMIN',
                    'katalaluan' => '123',
                ],
                [
                    'kelas_id' => 2,
                    'nama' => 'Farisyah',
                    'nokp' => '123567891016',
                    'tahap' => 'ADMIN',
                    'katalaluan' => '123',
                ],
                [
                    'kelas_id' => 3,
                    'nama' => 'Anis',
                    'nokp' => '123678910145',
                    'tahap' => 'AHLI BIASA',
                    'katalaluan' => '123',
                ],
                [
                    'kelas_id' => 4,
                    'nama' => 'Alia',
                    'nokp' => '234678910111',
                    'tahap' => 'AHLI BIASA',
                    'katalaluan' => '123',
                ],
                [
                    'kelas_id' => 5,
                    'nama' => 'Irfan',
                    'nokp' => '234789101112',
                    'tahap' => 'AHLI BIASA',
                    'katalaluan' => '123',
                ],
                [
                    'kelas_id' => 6,
                    'nama' => 'Aiman',
                    'nokp' => '234891011121',
                    'tahap' => 'AHLI BIASA',
                    'katalaluan' => '123',
                ],
            ]);
        } else {
            echo "\e[31mTable is not empty, therefore NOT ";
        }
    }
}
