<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perawatan extends Model
{
    protected $fillable = [
        'nopol',
        'tanggal',
        'sparepart',
        'harga',
        'satuan',
        'total'
    ];
}
