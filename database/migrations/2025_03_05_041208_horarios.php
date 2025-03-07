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
        Schema::create('horarios', function (Blueprint $table) {
            
            $table->id();
            $table->foreignId('eventos_id')->constrained('eventos');
            $table->date('start_date')->nullable()->default(null);
            $table->time('start_hour')->nullable()->default(null);
            $table->time('end_hour')->nullable()->default(null);
            $table->date('end_date')->nullable()->default(null);

            // Agregar el campo deleted_at para SoftDeletes
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
