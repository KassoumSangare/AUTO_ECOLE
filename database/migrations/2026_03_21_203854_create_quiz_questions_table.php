<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['code', 'conduite']);
            $table->text('question');
            $table->json('options');          // ["option A", "option B", "option C", "option D"]
            $table->unsignedTinyInteger('correct_index'); // index de la bonne réponse (0-3)
            $table->text('explication')->nullable();      // Explication affichée après réponse
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};