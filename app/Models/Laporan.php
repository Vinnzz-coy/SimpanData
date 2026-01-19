<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $fillable = [
        'peserta_id',
        'judul',
        'deskripsi',
        'file_path',
        'tanggal_laporan',
        'status',
    ];
    protected $casts = [
        'tanggal_laporan' => 'date',
    ];
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}
