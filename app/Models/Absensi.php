<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $fillable = [
        'peserta_id',
        'jenis_absen',
        'waktu_absen',
        'wa_pengirim',
        'status',
    ];
    protected $casts = [
        'waktu_absen' => 'datetime',
    ];
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}
