<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lapangan extends Model
{
    protected $table = 'lapangans';

    public $timestamps = false;

    protected $fillable = [
        'area_id',
        'kode',
        'nama_lapangan',
        'cabang_olahraga',
        'jenis_permukaan',
        'panjang',
        'lebar',
        'status_fisik',
        'keterangan',
    ];

    public const PERMUKAAN = [
        'rumput_alami'    => 'Rumput alami',
        'rumput_sintetis' => 'Rumput sintetis',
        'vinyl'           => 'Vinyl',
        'parket'          => 'Parket',
        'semen'           => 'Semen',
        'karpet'          => 'Karpet',
    ];

    public const STATUS_FISIK = [
        'baik'            => 'Baik',
        'perlu_perbaikan' => 'Perlu perbaikan',
        'rusak'           => 'Rusak',
    ];

    public const KELAS_STATUS = [
        'baik'            => 'baik',
        'perlu_perbaikan' => 'perbaikan',
        'rusak'           => 'rusak',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function getNamaPermukaanAttribute(): string
    {
        return self::PERMUKAAN[$this->jenis_permukaan] ?? $this->jenis_permukaan;
    }

    public function getLabelStatusAttribute(): string
    {
        return self::STATUS_FISIK[$this->status_fisik] ?? $this->status_fisik;
    }

    public function getKelasStatusAttribute(): string
    {
        return self::KELAS_STATUS[$this->status_fisik] ?? 'baik';
    }
}
