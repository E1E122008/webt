<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'nama', 'jenis', 'bidang', 'deskripsi', 'gambar', 'status', 'jumlah_unit'
    ];
}
