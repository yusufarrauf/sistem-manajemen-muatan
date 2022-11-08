<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekapitulasi extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'ke',
        'jenis',
        'range_from',
        'range_to',
    ];
}
