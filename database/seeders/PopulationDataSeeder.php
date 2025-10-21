<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Population;
use Carbon\Carbon;

class PopulationDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $populations = [
            [
                'no_kk' => '7402010403080015',
                'nik' => '7402010101690006',
                'nama' => 'KEMBANG',
                'alamat_kk' => 'TETEMBOMUA',
                'jenis_kelamin' => 'L',
                'hubungan_kepala_keluarga' => 'KK',
                'tempat_lahir' => 'Wajo',
                'status_perkawinan' => 'Kawin',
                'suku' => 'Bugis',
                'pendidikan_terakhir' => 'SMP',
                'mata_pencaharian' => 'Petani',
                'pekerjaan_tambahan' => 'Ternak Sapi',
                'luas_lahan_pertanian' => 25000,
                'komoditas_utama' => 'Sawit',
                'komoditas_buah_sayur' => '',
                'bantuan' => 'PKI',
                'dusun_id' => 1,
                'mobil' => 0,
                'motor' => 1,
                'sepeda' => 0,
                'sapi' => 3,
                'kambing' => 0,
                'ayam' => 0,
                'status_kepemilikan_rumah' => 'MILIK SENDIRI',
                'status_dinding' => 'CAMPURAN',
                'status_atap' => 'SENG',
                'kk_dikeluarkan' => '2023-11-28',
                'tanggal_lahir' => '1966-01-01',
            ],
            [
                'no_kk' => '7402012505100004',
                'nik' => '7402015310700001',
                'nama' => 'MULYANA',
                'alamat_kk' => 'TETEMBOMUA',
                'jenis_kelamin' => 'L',
                'hubungan_kepala_keluarga' => 'ISTRI',
                'tempat_lahir' => 'Tetembomua',
                'status_perkawinan' => 'Kawin',
                'suku' => 'Bugis',
                'pendidikan_terakhir' => 'SD',
                'mata_pencaharian' => 'Petani',
                'pekerjaan_tambahan' => '',
                'luas_lahan_pertanian' => 10000,
                'komoditas_utama' => 'KELAPA, LADA DAN KAKAO',
                'komoditas_buah_sayur' => '',
                'bantuan' => '',
                'dusun_id' => 1,
                'mobil' => 0,
                'motor' => 1,
                'sepeda' => 0,
                'sapi' => 5,
                'kambing' => 10,
                'ayam' => 0,
                'status_kepemilikan_rumah' => 'MILIK SENDIRI',
                'status_dinding' => 'PAPAN',
                'status_atap' => 'SENG',
                'kk_dikeluarkan' => '2019-07-26',
                'tanggal_lahir' => '1970-10-13',
            ],
            // Tambahkan data lainnya di sini...
        ];

        foreach ($populations as $population) {
            Population::create($population);
        }
    }
}





