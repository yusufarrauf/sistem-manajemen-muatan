<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataGaji extends Model
{
    protected $fillable = [
        'nama',
        'gaji_pokok'
    ];
}
