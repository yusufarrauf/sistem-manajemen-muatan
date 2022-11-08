<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalPerawatan extends Model
{
    protected $fillable = [
        'nopol',
        'tanggal',
        'sparepart',
        'harga',
        'satuan',
        'total',
        'isApprove'
    ];
}
