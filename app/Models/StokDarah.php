<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokDarah extends Model
{
    protected $fillable = [
        'golongan_darah',
        'rhesus',
        'jumlah_kantong',
    ];
}


