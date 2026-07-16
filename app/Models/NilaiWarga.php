<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiWarga extends Model
{
    /** @use HasFactory<\Database\Factories\NilaiWargaFactory> */
    use HasFactory;

    protected $fillable = [
        'warga_id',
        'kriteria_id',
        'nilai',
        'nilai_normalisasi',
    ];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}
