<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Population extends Model
{
    protected $fillable = [
        'no_kk', 'nik', 'nama', 'alamat_kk', 'kk_dikeluarkan',
        'jenis_kelamin', 'hubungan_kepala_keluarga', 'tempat_lahir',
        'tanggal_lahir', 'bulan_lahir', 'tahun_lahir',
        'status_perkawinan', 'suku', 'pendidikan_terakhir',
        'mata_pencaharian', 'pekerjaan_tambahan',
        'luas_lahan_pertanian', 'komoditas_utama', 'komoditas_buah_sayur',
        'bantuan', 'dusun',
        // Tambahan kolom kendaraan/ternak jika ada di Excel:
        'mobil', 'motor', 'sepeda', 'sapi', 'kambing', 'ayam',
        // Kolom status rumah jika ada
        'status_kepemilikan_rumah', 'status_dinding', 'status_atap', 'status_lantai',
    ];
}
