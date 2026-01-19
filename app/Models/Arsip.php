<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $table = 'arsip';
    protected $fillable = [
        'peserta_id',
        'file_path',
        'diarsipkan_pada',
        'catatan',
    ];
    protected $casts = [
        'diarsipkan_pada' => 'date',
    ];
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}
