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
        Schema::create('permit_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // A, B, AB, BCDE, ABCDE
            $table->string('name'); // Nom complet de la catégorie
            $table->text('description')->nullable(); // Description optionnelle
            $table->decimal('price', 10, 2); // Prix en XOF
            $table->decimal('online_discount_percent', 5, 2)->default(0); // % de réduction en ligne
            $table->boolean('is_active')->default(true); // Catégorie active/inactive
            $table->integer('display_order')->default(0); // Ordre d'affichage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permit_categories');
    }
};