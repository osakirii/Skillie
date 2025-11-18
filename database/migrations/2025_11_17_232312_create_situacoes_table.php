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
        Schema::create('situacoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('desc')->nullable();
            $table->foreignId('carreira_id')->constrained('carreiras')->cascadeOnDelete();
            $table->foreignID('decisao1_id')->constrained('cartas')->cascadeOnDelete();
            $table->foreignID('decisao2_id')->constrained('cartas')->cascadeOnDelete();
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('situacoes');
    }
};
