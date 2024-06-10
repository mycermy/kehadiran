<?php

namespace Database\Seeders;

use App\Models\Aktiviti;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AktivitiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Aktiviti::count() == 0) {
            # code...
            Aktiviti::insert([
                [
                    'tarikh' => '2023-02-22',
                    'masa_mula' => '9:00 Pagi',
                    'nama_aktiviti' => 'Perjumpaan',
                ],
                [
                    'tarikh' => '2023-04-25',
                    'masa_mula' => '10:00 Pagi',
                    'nama_aktiviti' => 'Menyampaikan maklumat kesihatan',
                ],
                [
                    'tarikh' => '2023-07-23',
                    'masa_mula' => '11:00 Pagi',
                    'nama_aktiviti' => 'Merawat kecederaan ringan',
                ],
                [
                    'tarikh' => '2023-09-29',
                    'masa_mula' => '9:30 Pagi',
                    'nama_aktiviti' => 'Pemberitahuan masalah kesihatan',
                ],
            ]);
        } else {
            echo "\e[31mTable is not empty, therefore NOT ";
        }
    }
}
