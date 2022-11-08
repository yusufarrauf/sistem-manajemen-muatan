<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataKendaraan extends Model
{
    protected $fillable = [
        'nopol',
        'vendor',
        'supir',
        'status',
    ];
}
