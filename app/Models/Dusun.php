<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dusun extends Model
{
    protected $fillable = [
        'nama'
    ];

    public function populations()
    {
        return $this->hasMany(Population::class);
    }
}
