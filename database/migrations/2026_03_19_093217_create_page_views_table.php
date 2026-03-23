<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('page', 100)->default('home');
            $table->unsignedBigInteger('count')->default(0);
            $table->timestamps();

            $table->unique('page');
        });

        // Seed initial du compteur pour la home
        DB::table('page_views')->insert([
            'page'       => 'home',
            'count'      => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
