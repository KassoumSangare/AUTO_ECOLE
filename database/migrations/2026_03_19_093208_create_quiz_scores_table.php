<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->enum('category', ['code', 'conduite']);
            $table->unsignedTinyInteger('score');          // Score obtenu (ex: 14)
            $table->unsignedTinyInteger('total_questions'); // Total questions (ex: 20)
            $table->decimal('percentage', 5, 2)
                  ->storedAs('(score / total_questions) * 100'); // Colonne calculée
            $table->unsignedSmallInteger('duration_seconds')->nullable(); // Temps mis
            $table->timestamps();

            // Index pour le dashboard pédagogique admin
            $table->index(['user_id', 'category']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_scores');
    }
};
