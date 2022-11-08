<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $fillable = [
        'id_karyawan',
        'gaji_pokok',
        'biaya_lain',
        'total_gaji'
    ];
}
