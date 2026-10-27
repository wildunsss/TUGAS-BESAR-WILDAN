<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    protected $table = 'areas';

    public $timestamps = false;

    protected $fillable = [
        'nama_area',
        'tipe',
        'deskripsi',
    ];

    public function lapangans(): HasMany
    {
        return $this->hasMany(Lapangan::class, 'area_id');
    }
}
