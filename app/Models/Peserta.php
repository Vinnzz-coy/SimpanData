<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $foto
 * @property string $nama
 * @property string $asal_sekolah_universitas
 * @property string $jurusan
 * @property string|null $alamat
 * @property string|null $no_telepon
 * @property string $jenis_kegiatan
 * @property \Illuminate\Support\Carbon $tanggal_mulai
 * @property \Illuminate\Support\Carbon $tanggal_selesai
 * @property string $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $user
 */
class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';
    protected $fillable = [
        'user_id',
        'foto',
        'nama',
        'asal_sekolah_universitas',
        'jurusan',
        'alamat',
        'no_telepon',
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

    public function penilaian()
    {
        return $this->hasOne(Penilaian::class);
    }
}
