<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Warga extends Model
{
    /** @use HasFactory<\Database\Factories\WargaFactory> */
    use HasFactory;

    protected $fillable = [
        "nik",
        "nama",
        "dusun",
        "alamat",
        "pekerjaan",
        "latitude",
        "longitude",
    ];

    public function nilaiWargas(): HasMany
    {
        return $this->hasMany(NilaiWarga::class);
    }

    public function hasilClusterings(): HasMany
    {
        return $this->hasMany(HasilClustering::class);
    }

    /**
     * Get formatted nilai wargas for display.
     *
     * @return array<array{kode: string, nilai: string, nama: string}>
     */
    public function getFormattedNilaiWargas(): array
    {
        return $this->nilaiWargas
            ->map(function (NilaiWarga $nilai) {
                $val = $nilai->nilai;
                $kode = $nilai->kriteria->kode;

                if ($kode === "C1") {
                    $val = "Rp " . number_format($val / 1000, 0) . "k";
                } elseif ($kode === "C3") {
                    $edu = [0 => "TS", 1 => "SD", 2 => "SMP", 3 => "SMA"];
                    $val = $edu[$val] ?? $val;
                } elseif ($kode === "C4") {
                    $house = [1 => "TL", 2 => "KL", 3 => "L"];
                    $val = $house[$val] ?? $val;
                }

                return [
                    "kode" => $kode,
                    "nilai" => $val,
                    "nama" => $nilai->kriteria->nama,
                ];
            })
            ->toArray();
    }
}
