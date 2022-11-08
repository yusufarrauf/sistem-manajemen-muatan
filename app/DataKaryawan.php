<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataKaryawan extends Model
{
    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'handphone',
        'jabatan',
    ];
}
