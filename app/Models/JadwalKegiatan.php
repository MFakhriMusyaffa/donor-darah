<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKegiatan extends Model
{
    protected $fillable = [
        'event_name',
        'start_event',
        'end_event',
        'location',
        'detail'
    ];
}
