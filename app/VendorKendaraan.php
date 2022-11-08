<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorKendaraan extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'username',
        'password'
    ];
    protected $hidden = [
        'password',
    ];
}
