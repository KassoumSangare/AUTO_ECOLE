<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MediathequeController extends Controller
{
    /**
     * Playlists YouTube organisées par catégorie.
     * Remplace les IDs par tes vraies vidéos YouTube.
     */
    private array $playlists = [
        'code' => [
            'titre'    => 'Code de la Route',
            'icone'    => 'bi-signpost-2-fill',
            'couleur'  => '#C8102E',
            'videos'   => [
                [
                    'id'          => 'xN-GGwtQk3o', // ← Remplace par ton vrai ID YouTube
                    'titre'       => 'Les panneaux de signalisation',
                    'description' => 'Apprenez à reconnaître tous les panneaux de signalisation routière.',
                    'duree'       => '25:18',
                ],
                [
                    'id'          => '6ORtgRaKths',
                    'titre'       => 'Priorités et intersections',
                    'description' => 'Maîtrisez les règles de priorité aux carrefours et ronds-points.',
                    'duree'       => '10:00',
                ],
                [
                    'id'          => 'ceg9LWC0_Zw',
                    'titre'       => 'Vitesse et distances de sécurité',
                    'description' => 'Les limites de vitesse et comment calculer votre distance de freinage.',
                    'duree'       => '08:42',
                ],
                [
                    'id'          => '5mIPMthysnY',
                    'titre'       => 'Alcool, médicaments et conduite',
                    'description' => 'Comprendre les effets des substances sur la conduite.',
                    'duree'       => '07:20',
                ],
            ],
        ],
        'conduite' => [
            'titre'    => 'Techniques de Conduite',
            'icone'    => 'bi-steering2',
            'couleur'  => '#009A44',
            'videos'   => [
                [
                    'id'          => 'ZlML_3s9QvA',
                    'titre'       => 'Démarrage et arrêt en côte',
                    'description' => 'La technique du frein à main pour démarrer en côte sans reculer.',
                    'duree'       => '11:08',
                ],
                [
                    'id'          => 'hY-BHC_rluA',
                    'titre'       => 'Le créneau et le garage',
                    'description' => 'Réussir votre stationnement en créneau et en épi.',
                    'duree'       => '14:55',
                ],
                [
                    'id'          => 'DUHfH2xlUNc',
                    'titre'       => 'Conduite de nuit',
                    'description' => 'Adapter votre conduite aux conditions nocturnes.',
                    'duree'       => '08:30',
                ],
                [
                    'id'          => 'hRioJNzrdA0',
                    'titre'       => 'Freinage d\'urgence avec ABS',
                    'description' => 'Comment réagir correctement en cas d\'urgence.',
                    'duree'       => '06:45',
                ],
            ],
        ],
        'securite' => [
            'titre'    => 'Sécurité Routière',
            'icone'    => 'bi-shield-check',
            'couleur'  => '#856404',
            'videos'   => [
                [
                    'id'          => '34qkQVskV04',
                    'titre'       => 'La ceinture de sécurité',
                    'description' => 'Pourquoi et comment porter correctement sa ceinture.',
                    'duree'       => '05:12',
                ],
                [
                    'id'          => 'ZlML_3s9QvA',
                    'titre'       => 'En cas d\'accident',
                    'description' => 'Les bons réflexes en cas d\'accident sur la route.',
                    'duree'       => '10:00',
                ],
            ],
        ],
    ];

    public function index(): View
    {
        $playlists    = $this->playlists;
        $totalVideos  = collect($playlists)->sum(fn($p) => count($p['videos']));

        return view('eleve.mediatheque', compact('playlists', 'totalVideos'));
    }
}
