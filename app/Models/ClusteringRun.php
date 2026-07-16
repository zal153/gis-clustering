<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class ClusteringRun extends Model
{
    /** @use HasFactory<\Database\Factories\ClusteringRunFactory> */
    use HasFactory;

    protected $fillable = [
        'k_value',
        'silhouette_score',
        'jumlah_data',
        'metode',
        'run_date',
    ];

    protected $casts = [
        'run_date' => 'datetime',
    ];

    public function hasilClusterings(): HasMany
    {
        return $this->hasMany(HasilClustering::class);
    }
}
