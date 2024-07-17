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
                    'nama' => 'Anas',
                    'nokp' => '123456789101',
                    'jantina' => 'LELAKI',
                    'email' => fake()->freeEmail(),
                    'katalaluan' => '123',
                ],
                [
                    'kelas_id' => 2,
                    'nama' => 'Farisyah',
                    'nokp' => '123567891016',
                    'jantina' => 'PEREMPUAN',
                    'email' => fake()->freeEmail(),
                    'katalaluan' => '123',
                ],
                [
                    'kelas_id' => 3,
                    'nama' => 'Anis',
                    'nokp' => '123678910148',
                    'jantina' => 'PEREMPUAN',
                    'email' => fake()->freeEmail(),
                    'katalaluan' => '123',
                ],
                [
                    'kelas_id' => 4,
                    'nama' => 'Alias Sabran',
                    'nokp' => '234678910111',
                    'jantina' => 'LELAKI',
                    'email' => fake()->freeEmail(),
                    'katalaluan' => '123',
                ],
                [
                    'kelas_id' => 5,
                    'nama' => 'Irfan',
                    'nokp' => '234789101117',
                    'jantina' => 'LELAKI',
                    'email' => fake()->freeEmail(),
                    'katalaluan' => '123',
                ],
                [
                    'kelas_id' => 6,
                    'nama' => 'Aiman',
                    'nokp' => '234891011121',
                    'jantina' => 'LELAKI',
                    'email' => fake()->freeEmail(),
                    'katalaluan' => '123',
                ],
            ]);
        } else {
            echo "\e[31mTable is not empty, therefore NOT ";
        }
    }
}
