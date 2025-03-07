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
        Schema::create('eventos', function (Blueprint $table) {
            
            $table->id();
            $table->foreignId('users_id')->constrained('users');
            $table->foreignId('organizadors_id')->constrained('organizadors');
            $table->foreignId('foros_id')->constrained('foros');
            $table->string('title', 255);
            $table->string('tipo_evento', 35);
            $table->text('notas_generales')->nullable()->default(null);
            $table->text('notas_cta')->nullable()->default(null);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
