<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
        use HasFactory;

    protected $table = 'masyarakat';

    protected $fillable = [
        'user_id',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'email',
        'no_hp',
        'alamat'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pendonor()
    {
        return $this->hasOne(Pendonor::class);
    }
}
