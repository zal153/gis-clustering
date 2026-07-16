<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilClustering extends Model
{
    /** @use HasFactory<\Database\Factories\HasilClusteringFactory> */
    use HasFactory;

    protected $fillable = [
        'clustering_run_id',
        'warga_id',
        'cluster_number',
        'jarak_centroid',
    ];

    public function clusteringRun(): BelongsTo
    {
        return $this->belongsTo(ClusteringRun::class);
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }
}
