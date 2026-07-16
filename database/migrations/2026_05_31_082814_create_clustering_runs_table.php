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
        Schema::create('clustering_runs', function (Blueprint $table) {
            $table->id();
            $table->integer('k_value');
            $table->decimal('silhouette_score', 6, 4)->nullable();
            $table->integer('jumlah_data');
            $table->string('metode')->default('K-Means');
            $table->timestamp('run_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clustering_runs');
    }
};
