<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->enum('type', ['cni', 'photo', 'certificat']); // Extensible
            $table->string('path');                 // Chemin stockage (storage/app/private/...)
            $table->string('original_name');        // Nom original du fichier
            $table->string('mime_type', 50);        // pdf, image/jpeg, image/png
            $table->unsignedBigInteger('size');     // Taille en octets
            $table->enum('status', ['en_attente', 'valide', 'rejete'])->default('en_attente');
            $table->text('commentaire_admin')->nullable(); // Motif de rejet éventuel
            $table->timestamps();

            // Index pour filtrage admin
            $table->index(['user_id', 'type']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
