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
                    'tarikh' => '2024-02-01',
                    'nama_aktiviti' => 'Orientasi Murid Tahun 1',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-02-07',
                    'nama_aktiviti' => 'Kejohanan Sukan Olahraga',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-02-14',
                    'nama_aktiviti' => 'Hari Anugerah Cemerlang tahun lepas',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-02-21',
                    'nama_aktiviti' => 'Program Pusat Sumber Sekolah (PSS)',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-02-28',
                    'nama_aktiviti' => 'Senamrobik bersama pengerusi PIBG',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-03-07',
                    'nama_aktiviti' => 'Menu Sihat KKM Negeri Perak',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-03-14',
                    'nama_aktiviti' => 'Kursus Kepimpinan Untuk Semua Pengawas Sekolah',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-03-21',
                    'nama_aktiviti' => 'Perkhemahan Peringkat Sekolah',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-03-28',
                    'nama_aktiviti' => 'Program Gilap Sinar',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-04-07',
                    'nama_aktiviti' => 'Latih Tubi Intensif Untuk Pelajar PT3 dan SPM',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-04-14',
                    'nama_aktiviti' => 'Kelas Bimbingan dan Kaunseling',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-04-21',
                    'nama_aktiviti' => 'Sediakan Kerja Cuti Terancang',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-04-29',
                    'nama_aktiviti' => 'Program Pembimbing Rakan Sebaya',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-05-07',
                    'nama_aktiviti' => 'Program Pasca PT3',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-05-14',
                    'nama_aktiviti' => 'Kem Membaca 1 Malaysia',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-05-21',
                    'nama_aktiviti' => 'Program Gerak Bestari',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-05-29',
                    'nama_aktiviti' => 'Larian Kecergasan unit Beruniform',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-06-07',
                    'nama_aktiviti' => 'Program Minda Segar',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-06-14',
                    'nama_aktiviti' => 'Teknik Menjawab PT3 Dan SPM',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-06-21',
                    'nama_aktiviti' => 'Penyertaan Pancaragam Ceramah bersama Pakar Motivasi',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-06-29',
                    'nama_aktiviti' => 'Senam Seni 1 Malaysia',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-07-07',
                    'nama_aktiviti' => 'Kursus Pemantapan Sahsiah Dan Penajaan Petrosains',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-07-14',
                    'nama_aktiviti' => 'Kelas Bimbingan Terancang SPM',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-07-21',
                    'nama_aktiviti' => 'Program Pasca SPM',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-07-29',
                    'nama_aktiviti' => 'Darurat SPM',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-08-07',
                    'nama_aktiviti' => 'Kelas Tutorial Subjek Teras',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-08-14',
                    'nama_aktiviti' => 'Bengkel Menjajawab Peperiksaan',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-08-21',
                    'nama_aktiviti' => 'Jalinan, Jaringan Dan Pengantarabangsaan',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-08-31',
                    'nama_aktiviti' => 'Jalur Gemilang',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-09-07',
                    'nama_aktiviti' => 'Laman Web PIBG',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-09-14',
                    'nama_aktiviti' => 'Meraikan Kejayaan Pelajar Cemerlang PMR Dan Semua Guru',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-09-16',
                    'nama_aktiviti' => 'Malaysia!',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-09-21',
                    'nama_aktiviti' => 'Taman PIBG',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-09-29',
                    'nama_aktiviti' => 'Cerna Minda',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-10-07',
                    'nama_aktiviti' => 'Pertandingan Bowling Peringkat Negeri',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-10-14',
                    'nama_aktiviti' => 'Gotong Royong Perdana',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-10-21',
                    'nama_aktiviti' => 'Teknik Menjawab PT3 Dan SPM',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-10-29',
                    'nama_aktiviti' => 'Resepi Cemerlang PT3',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-11-01',
                    'nama_aktiviti' => 'Pertandingan Mural',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-11-07',
                    'nama_aktiviti' => 'Pertandingan Mencipta Mercu Tanda Sekolah',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-11-14',
                    'nama_aktiviti' => 'Pertandingan SEM Antarabangsa',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-11-21',
                    'nama_aktiviti' => 'Persembahan Aeronautic',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-11-29',
                    'nama_aktiviti' => 'Perkhemahan Unit Beruniform',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-12-01',
                    'nama_aktiviti' => 'Pertandingan Perbarisan Wakil Sekolah',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-12-02',
                    'nama_aktiviti' => 'Rapat Umum Bersama Ibu Bapa dan Guru',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-12-05',
                    'nama_aktiviti' => 'Lawatan Sambil Belajar',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-12-07',
                    'nama_aktiviti' => 'Lawatan Kelas Untuk Pelajar Tingkatan 5',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-12-14',
                    'nama_aktiviti' => 'Majlis Solat Hajat',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-12-15',
                    'nama_aktiviti' => 'Majlis Khatam Al-Quran',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-12-16',
                    'nama_aktiviti' => 'Ceramah Sahsiah Dan Pembangunan Remaja',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-12-17',
                    'nama_aktiviti' => 'Penghayatan Besarnya Pengorbanan Ibu bapa',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-12-21',
                    'nama_aktiviti' => 'Majlis Persaraan Pengetua',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-12-29',
                    'nama_aktiviti' => 'Majlis Sambutan Hari Raya Sekolah',
                    'keterangan' => fake()->paragraph(),
                ],
                [
                    'tarikh' => '2024-12-31',
                    'nama_aktiviti' => 'Majlis Sambutan Maulidur Rasul',
                    'keterangan' => fake()->paragraph(),
                ],
            ]);
        } else {
            echo "\e[31mTable is not empty, therefore NOT ";
        }
    }
}
