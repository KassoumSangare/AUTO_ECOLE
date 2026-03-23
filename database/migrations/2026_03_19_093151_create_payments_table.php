<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Données Wave
            $table->string('reference_wave')->unique(); // ID transaction Wave
            $table->string('wave_checkout_id')->nullable(); // ID session checkout Wave
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('XOF'); // Franc CFA
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');

            // Reçu généré
            $table->string('receipt_path')->nullable(); // Chemin vers le PDF généré
            $table->string('receipt_number')->nullable()->unique(); // N° de reçu formaté

            // Métadonnées Wave (payload webhook brut pour audit)
            $table->json('wave_payload')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            // Index pour le reporting financier
            $table->index('status');
            $table->index('paid_at');
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
