<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'peserta_id',
        'jenis_absen',
        'waktu_absen',
        'mode_kerja',
        'keterangan_kehadiran',
        'alasan_terlambat',
        'bukti_terlambat',
        'status',
        'wa_pengirim',
    ];

    protected $casts = [
        'waktu_absen' => 'datetime',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}
