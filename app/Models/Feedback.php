<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';
    protected $fillable = [
        'peserta_id',
        'pengirim',
        'pesan',
        'tampilkan',
        'rating',
        'dibaca',
    ];
    protected $casts = [
        'dibaca' => 'boolean',
        'tampilkan' => 'boolean',
    ];
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}
