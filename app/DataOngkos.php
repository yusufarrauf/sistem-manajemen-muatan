<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataOngkos extends Model
{
    protected $fillable = [
        'asal',
        'tujuan',
        'kota',
        'ongkos_vendor',
        'ongkos_invoice',
        'supir_perton',
        'mobil_perton',
        'bonus',
        'panjar'
    ];
}
