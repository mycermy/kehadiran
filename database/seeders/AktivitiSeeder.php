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
                ],
                [
                    'tarikh' => '2024-02-07',
                    'nama_aktiviti' => 'Kejohanan Sukan Olahraga',
                ],
                [
                    'tarikh' => '2024-02-14',
                    'nama_aktiviti' => 'Hari Anugerah Cemerlang tahun lepas',
                ],
                [
                    'tarikh' => '2024-02-21',
                    'nama_aktiviti' => 'Program Pusat Sumber Sekolah (PSS)',
                ],
                [
                    'tarikh' => '2024-02-28',
                    'nama_aktiviti' => 'Senamrobik bersama pengerusi PIBG',
                ],
                [
                    'tarikh' => '2024-03-07',
                    'nama_aktiviti' => 'Senamrobik bersama pengerusi PIBG',
                ],
                [
                    'tarikh' => '2024-03-14',
                    'nama_aktiviti' => 'Kursus Kepimpinan Untuk Semua Pengawas Sekolah',
                ],
                [
                    'tarikh' => '2024-03-21',
                    'nama_aktiviti' => 'Perkhemahan Peringkat Sekolah',
                ],
                [
                    'tarikh' => '2024-03-28',
                    'nama_aktiviti' => 'Program Gilap Sinar',
                ],
                [
                    'tarikh' => '2024-04-07',
                    'nama_aktiviti' => 'Latih Tubi Intensif Untuk Pelajar PT3 dan SPM',
                ],
                [
                    'tarikh' => '2024-04-14',
                    'nama_aktiviti' => 'Kelas Bimbingan dan Kaunseling',
                ],
                [
                    'tarikh' => '2024-04-21',
                    'nama_aktiviti' => 'Sediakan Kerja Cuti Terancang',
                ],
                [
                    'tarikh' => '2024-04-29',
                    'nama_aktiviti' => 'Program Pembimbing Rakan Sebaya',
                ],
                [
                    'tarikh' => '2024-05-07',
                    'nama_aktiviti' => 'Program Pasca PMR',
                ],
                [
                    'tarikh' => '2024-05-14',
                    'nama_aktiviti' => 'Kem Membaca 1 Malaysia',
                ],
                [
                    'tarikh' => '2024-05-21',
                    'nama_aktiviti' => 'Program Gerak Bestari',
                ],
                [
                    'tarikh' => '2024-05-29',
                    'nama_aktiviti' => 'Larian Kecergasan unit Beruniform',
                ],
                [
                    'tarikh' => '2024-06-07',
                    'nama_aktiviti' => 'Program Minda Segar',
                ],
                [
                    'tarikh' => '2024-06-14',
                    'nama_aktiviti' => 'Teknik Menjawab PMR Dan SPM',
                ],
                [
                    'tarikh' => '2024-06-21',
                    'nama_aktiviti' => 'Penyertaan Pancaragam Ceramah bersama Pakar Motivasi',
                ],
                [
                    'tarikh' => '2024-06-29',
                    'nama_aktiviti' => 'Senam Seni 1 Malaysia',
                ],
                [
                    'tarikh' => '2024-07-07',
                    'nama_aktiviti' => 'Kursus Pemantapan Sahsiah Dan Penajaan Petrosains',
                ],
                [
                    'tarikh' => '2024-07-14',
                    'nama_aktiviti' => 'Kelas Bimbingan Terancang SPM',
                ],
                [
                    'tarikh' => '2024-07-21',
                    'nama_aktiviti' => 'Program Pasca SPM',
                ],
                [
                    'tarikh' => '2024-07-29',
                    'nama_aktiviti' => 'Darurat SPM',
                ],
                [
                    'tarikh' => '2024-08-07',
                    'nama_aktiviti' => 'Kelas Tutorial Subjek Teras',
                ],
                [
                    'tarikh' => '2024-08-14',
                    'nama_aktiviti' => 'Bengkel Menjajawab Peperiksaan',
                ],
                [
                    'tarikh' => '2024-08-21',
                    'nama_aktiviti' => 'Jalinan, Jaringan Dan Pengantarabangsaan',
                ],
                [
                    'tarikh' => '2024-08-31',
                    'nama_aktiviti' => 'Jalur Gemilang',
                ],
                [
                    'tarikh' => '2024-09-07',
                    'nama_aktiviti' => 'Laman Web PIBG',
                ],
                [
                    'tarikh' => '2024-09-14',
                    'nama_aktiviti' => 'Meraikan Kejayaan Pelajar Cemerlang PMR Dan Semua Guru',
                ],
                [
                    'tarikh' => '2024-09-16',
                    'nama_aktiviti' => 'Malaysia!',
                ],
                [
                    'tarikh' => '2024-09-21',
                    'nama_aktiviti' => 'Taman PIBG',
                ],
                [
                    'tarikh' => '2024-09-29',
                    'nama_aktiviti' => 'Cerna Minda',
                ],
                [
                    'tarikh' => '2024-10-07',
                    'nama_aktiviti' => 'Pertandingan Bowling Peringkat Negeri',
                ],
                [
                    'tarikh' => '2024-10-14',
                    'nama_aktiviti' => 'Gotong Royong Perdana',
                ],
                [
                    'tarikh' => '2024-10-21',
                    'nama_aktiviti' => 'Teknik Menjawab PT3 Dan SPM'
                ],
                [
                    'tarikh' => '2024-10-29',
                    'nama_aktiviti' => 'Resepi Cemerlang PT3',
                ],
                [
                    'tarikh' => '2024-11-01',
                    'nama_aktiviti' => 'Pertandingan Mural',
                ],
                [
                    'tarikh' => '2024-11-07',
                    'nama_aktiviti' => 'Pertandingan Mencipta Mercu Tanda Sekolah',
                ],
                [
                    'tarikh' => '2024-11-14',
                    'nama_aktiviti' => 'Pertandingan SEM Antarabangsa',
                ],
                [
                    'tarikh' => '2024-11-21',
                    'nama_aktiviti' => 'Persembahan Aeronautic',
                ],
                [
                    'tarikh' => '2024-11-29',
                    'nama_aktiviti' => 'Perkhemahan Unit Beruniform',
                ],
                [
                    'tarikh' => '2024-12-01',
                    'nama_aktiviti' => 'Pertandingan Perbarisan Wakil Sekolah',
                ],
                [
                    'tarikh' => '2024-12-02',
                    'nama_aktiviti' => 'Rapat Umum Bersama Ibu Bapa dan Guru',
                ],
                [
                    'tarikh' => '2024-12-05',
                    'nama_aktiviti' => 'Lawatan Sambil Belajar',
                ],
                [
                    'tarikh' => '2024-12-07',
                    'nama_aktiviti' => 'Lawatan Kelas Untuk Pelajar Tingkatan 5',
                ],
                [
                    'tarikh' => '2024-12-14',
                    'nama_aktiviti' => 'Majlis Solat Hajat',
                ],
                [
                    'tarikh' => '2024-12-15',
                    'nama_aktiviti' => 'Majlis Khatam Al-Quran',
                ],
                [
                    'tarikh' => '2024-12-16',
                    'nama_aktiviti' => 'Ceramah Sahsiah Dan Pembangunan Remaja',
                ],
                [
                    'tarikh' => '2024-12-17',
                    'nama_aktiviti' => 'Penghayatan Besarnya Pengorbanan Ibu bapa',
                ],
                [
                    'tarikh' => '2024-12-21',
                    'nama_aktiviti' => 'Majlis Persaraan Pengetua',
                ],
                [
                    'tarikh' => '2024-12-29',
                    'nama_aktiviti' => 'Majlis Sambutan Hari Raya Sekolah',
                ],
                [
                    'tarikh' => '2024-12-31',
                    'nama_aktiviti' => 'Majlis Sambutan Maulidur Rasul',
                ],
            ]);
        } else {
            echo "\e[31mTable is not empty, therefore NOT ";
        }
    }
}
