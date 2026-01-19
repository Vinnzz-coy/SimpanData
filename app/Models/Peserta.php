<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';
    protected $fillable = [
        'user_id',
        'nama',
        'asal_sekolah',
        'jurusan',
        'alamat',
        'jenis_kegiatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
    public function arsip()
    {
        return $this->hasOne(Arsip::class);
    }
}
