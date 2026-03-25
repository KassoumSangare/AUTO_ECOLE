<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermitCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'code' => 'A',
                'name' => 'Permis A',
                'description' => 'Motocyclettes, tricycles et quadricycles à moteur',
                'price' => 85000,
                'online_discount_percent' => 10.00, // 10% de réduction en ligne
                'is_active' => true,
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'B',
                'name' => 'Permis B',
                'description' => 'Véhicules légers (voitures particulières)',
                'price' => 100000,
                'online_discount_percent' => 10.00,
                'is_active' => true,
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'AB',
                'name' => 'Permis AB',
                'description' => 'Combinaison des permis A et B',
                'price' => 110000,
                'online_discount_percent' => 10.00,
                'is_active' => true,
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'BCDE',
                'name' => 'Permis BCDE',
                'description' => 'Véhicules légers, poids lourds et transport en commun',
                'price' => 130000,
                'online_discount_percent' => 10.00,
                'is_active' => true,
                'display_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'ABCDE',
                'name' => 'Permis ABCDE',
                'description' => 'Toutes catégories de véhicules (formation complète)',
                'price' => 150000,
                'online_discount_percent' => 10.00,
                'is_active' => true,
                'display_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('permit_categories')->insert($categories);
    }
}