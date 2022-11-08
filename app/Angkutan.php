<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Angkutan extends Model
{
    protected $fillable = [
        'nopol',
        'tanggal',
        'transportir',
        'jenis_angkutan',
        'asal_pemuatan',
        'no_surat',
        'tujuan',
        'kota',
        'tonase',
        'ongkos_angkut',
        'supir_perton',
        'max_tonase',
        'ferry',
        'bonus_supir',
        'ton_bonus',
        'total_uj',
        'panjar',
        'sisa_uj',
        'status',
        'isFiltered'
    ];
}
