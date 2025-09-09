<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Population extends Model
{
    protected $fillable = [
        'no_kk', 'nik', 'nama', 'alamat', 'hubungan_kepala', 'keluarga', 'jenis_kelamin',
        'tempat_lahir', 'tanggal_lahir', 'status_perkawinan', 'suku', 'pendidikan', 'pekerjaan',
        'motor', 'mobil', 'sepeda', 'sapi', 'kambing', 'ayam',
        'luas_lahan_pertanian', 'luas_lahan_peternakan',
        'komoditas_utama', 'komoditas_buah_sayur', 'bantuan',
        'status_kepemilikan_rumah', 'status_dinding', 'status_atap', 'status_lantai'
    ];
}
