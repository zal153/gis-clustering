<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_clusterings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clustering_run_id')->constrained('clustering_runs')->onDelete('cascade');
            $table->foreignId('warga_id')->constrained('wargas')->onDelete('cascade');
            $table->integer('cluster_number');
            $table->decimal('jarak_centroid', 10, 6)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_clusterings');
    }
};
