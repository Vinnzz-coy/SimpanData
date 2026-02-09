<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $peserta_id
 * @property int $user_id
 * @property int $kedisiplinan
 * @property int $keterampilan
 * @property int $kerjasama
 * @property int $inisiatif
 * @property int $komunikasi
 * @property int $nilai_akhir
 * @property string|null $catatan
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Peserta $peserta
 * @property-read \App\Models\User $user
 */
class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';

    protected $fillable = [
        'peserta_id',
        'user_id',
        'kedisiplinan',
        'keterampilan',
        'kerjasama',
        'inisiatif',
        'komunikasi',
        'nilai_akhir',
        'catatan',
    ];

    /**
     * Hitung nilai akhir dari rata-rata semua aspek
     */
    public static function hitungNilaiAkhir(int $kedisiplinan, int $keterampilan, int $kerjasama, int $inisiatif, int $komunikasi): int
    {
        return (int) round(($kedisiplinan + $keterampilan + $kerjasama + $inisiatif + $komunikasi) / 5);
    }

    /**
     * Mendapatkan grade berdasarkan nilai
     */
    public function getGradeAttribute(): string
    {
        if ($this->nilai_akhir >= 90) return 'A';
        if ($this->nilai_akhir >= 80) return 'B';
        if ($this->nilai_akhir >= 70) return 'C';
        if ($this->nilai_akhir >= 60) return 'D';
        return 'E';
    }

    /**
     * Relasi ke peserta
     */
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    /**
     * Relasi ke user (admin yang menilai)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
