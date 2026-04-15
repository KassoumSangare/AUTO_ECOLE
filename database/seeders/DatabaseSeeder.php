<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Compte Admin initial ──────────────────────────────────────
        User::firstOrCreate(
            ['telephone' => '0700000000'],
            [
                'nom'       => 'Admin',
                'prenom'    => 'Le Chemin',
                'email'     => 'admin@autoecole-lechemin.ci',
                'password'  => Hash::make('Admin@2026!'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        // ── Élèves de test (dev uniquement) ──────────────────────────
        // Commenter en production avant le déploiement
        // User::factory(10)->create();

        // ── Questions du Quiz ─────────────────────────────────────────
        $this->call(QuizSeeder::class);
        $this->call([
            PermitCategorySeeder::class,
          
        ]);
    }
}
