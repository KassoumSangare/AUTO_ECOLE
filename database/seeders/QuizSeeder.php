<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // ── Questions CODE de la route ─────────────────────────
        $questionsCode = [
            [
                'question'      => 'À quelle distance minimale doit-on s\'arrêter devant un passage à niveau sans barrière ?',
                'options'       => ['5 mètres', '10 mètres', '15 mètres', '30 mètres'],
                'correct_index' => 1,
                'explication'   => 'La distance minimale d\'arrêt devant un passage à niveau sans barrière est de 10 mètres pour permettre un freinage d\'urgence du train.',
            ],
            [
                'question'      => 'Un feu tricolore rouge clignotant signifie :',
                'options'       => ['Ralentissez', 'Arrêt obligatoire', 'Cédez le passage', 'Passage interdit'],
                'correct_index' => 1,
                'explication'   => 'Le feu rouge clignotant impose un arrêt absolu. Il est utilisé notamment aux passages à niveau et dans certaines intersections dangereuses.',
            ],
            [
                'question'      => 'Quelle est la vitesse maximale autorisée en agglomération en Côte d\'Ivoire ?',
                'options'       => ['40 km/h', '50 km/h', '60 km/h', '70 km/h'],
                'correct_index' => 1,
                'explication'   => 'La vitesse maximale autorisée en agglomération est de 50 km/h, sauf indication contraire.',
            ],
            [
                'question'      => 'Le panneau triangulaire rouge avec un point d\'exclamation indique :',
                'options'       => ['Un virage dangereux', 'Un danger non spécifié', 'Une priorité', 'Une zone scolaire'],
                'correct_index' => 1,
                'explication'   => 'Ce panneau de danger général signale un danger non précisé. Il est toujours accompagné d\'un panneau complémentaire.',
            ],
            [
                'question'      => 'Que signifie la ligne blanche continue au centre de la chaussée ?',
                'options'       => ['On peut dépasser si la voie est libre', 'Dépassement interdit', 'Voie réservée aux bus', 'Zone de stationnement'],
                'correct_index' => 1,
                'explication'   => 'La ligne blanche continue (axiale) interdit formellement le dépassement et le franchissement.',
            ],
            [
                'question'      => 'Dans un rond-point, qui a la priorité ?',
                'options'       => ['Le véhicule qui entre', 'Le véhicule déjà engagé', 'Le véhicule venant de droite', 'Le véhicule le plus rapide'],
                'correct_index' => 1,
                'explication'   => 'Dans un giratoire (rond-point), les véhicules déjà engagés ont la priorité sur ceux qui souhaitent entrer.',
            ],
            [
                'question'      => 'Le port de la ceinture de sécurité est obligatoire :',
                'options'       => ['Uniquement sur autoroute', 'Uniquement en ville', 'Pour tous les passagers, partout', 'Seulement pour le conducteur'],
                'correct_index' => 2,
                'explication'   => 'La ceinture de sécurité est obligatoire pour tous les occupants du véhicule, quel que soit le type de route.',
            ],
            [
                'question'      => 'Que faut-il faire lorsque l\'on entend une sirène de véhicule d\'urgence ?',
                'options'       => ['Accélérer pour dégager la voie', 'S\'arrêter et laisser passer', 'Continuer normalement', 'Klaxonner pour avertir les autres'],
                'correct_index' => 1,
                'explication'   => 'On doit ralentir, se ranger sur le côté et s\'arrêter si nécessaire pour laisser passer les véhicules d\'urgence (pompiers, ambulance, police).',
            ],
            [
                'question'      => 'Quelle est la durée maximale légale de la conduite sans interruption ?',
                'options'       => ['2 heures', '3 heures', '4 heures', '5 heures'],
                'correct_index' => 2,
                'explication'   => 'Il est recommandé de ne pas conduire plus de 2 heures sans pause, mais la limite légale est de 4 heures consécutives pour les conducteurs professionnels.',
            ],
            [
                'question'      => 'Un piéton traverse hors d\'un passage protégé. Que faites-vous ?',
                'options'       => ['Klaxonnez et continuez', 'Freinez et laissez-le passer', 'Accélérez pour passer avant lui', 'Ignorez-le car il est en tort'],
                'correct_index' => 1,
                'explication'   => 'Même si le piéton est en infraction, votre sécurité et la sienne priment. Vous devez ralentir ou vous arrêter.',
            ],
            [
                'question'      => 'La distance de freinage dépend principalement de :',
                'options'       => ['La couleur du véhicule', 'La vitesse et l\'état des freins', 'La marque du véhicule', 'Le nombre de passagers'],
                'correct_index' => 1,
                'explication'   => 'La distance de freinage dépend de la vitesse (facteur le plus important), de l\'état des freins, des pneus et de l\'état de la chaussée.',
            ],
            [
                'question'      => 'Que signifie le panneau "Sens interdit" (cercle rouge avec barre blanche horizontale) ?',
                'options'       => ['Voie sans issue', 'Accès interdit à tous les véhicules', 'Stationnement interdit', 'Dépassement interdit'],
                'correct_index' => 1,
                'explication'   => 'Le panneau sens interdit interdit l\'accès à tous les véhicules dans le sens de la circulation indiqué.',
            ],
            [
                'question'      => 'En cas de panne sur la route, vous devez obligatoirement :',
                'options'       => ['Rester dans le véhicule', 'Placer un triangle de signalisation', 'Appeler la police avant tout', 'Pousser le véhicule'],
                'correct_index' => 1,
                'explication'   => 'En cas de panne, vous devez allumer vos feux de détresse et placer un triangle de signalisation à au moins 30 m du véhicule.',
            ],
            [
                'question'      => 'La consommation d\'alcool affecte la conduite en :',
                'options'       => ['Améliorant les réflexes', 'Augmentant le temps de réaction', 'N\'ayant aucun effet en faible quantité', 'Améliorant la vision nocturne'],
                'correct_index' => 1,
                'explication'   => 'L\'alcool, même en faible quantité, augmente le temps de réaction, diminue la vigilance et altère le jugement.',
            ],
            [
                'question'      => 'Que signifie un feu orange fixe ?',
                'options'       => ['Vous pouvez passer', 'Préparez-vous à vous arrêter', 'Priorité aux piétons', 'Voie libre'],
                'correct_index' => 1,
                'explication'   => 'Le feu orange fixe signifie que le feu va passer au rouge. Vous devez vous préparer à freiner et vous arrêter sauf si vous êtes trop engagé.',
            ],
            [
                'question'      => 'Le taux légal d\'alcoolémie maximum autorisé pour conduire est de :',
                'options'       => ['0,2 g/L de sang', '0,5 g/L de sang', '0,8 g/L de sang', '1,0 g/L de sang'],
                'correct_index' => 1,
                'explication'   => 'En Côte d\'Ivoire, le taux légal d\'alcoolémie est de 0,5 g/L de sang (0,25 mg/L d\'air expiré).',
            ],
            [
                'question'      => 'La signalisation verticale comprend :',
                'options'       => ['Les marquages au sol', 'Les panneaux de signalisation', 'Les feux tricolores uniquement', 'Les agents de circulation'],
                'correct_index' => 1,
                'explication'   => 'La signalisation verticale regroupe tous les panneaux routiers. Les marquages au sol constituent la signalisation horizontale.',
            ],
            [
                'question'      => 'Sur une voie à double sens, quelle est la règle de dépassement ?',
                'options'       => ['Dépasser par la droite', 'Dépasser par la gauche', 'Dépasser par n\'importe quel côté', 'Ne jamais dépasser'],
                'correct_index' => 1,
                'explication'   => 'Le dépassement s\'effectue par la gauche (côté conducteur) sauf exceptions (véhicule tournant à gauche, voie réservée).',
            ],
            [
                'question'      => 'Que faire quand les feux tricolores sont en panne ?',
                'options'       => ['Priorité à droite', 'Priorité au plus gros véhicule', 'Feux clignotants orange = priorité à droite', 'Continuer sans s\'arrêter'],
                'correct_index' => 2,
                'explication'   => 'En cas de panne des feux, un feu orange clignotant signale que la priorité à droite s\'applique à tous les conducteurs.',
            ],
            [
                'question'      => 'L\'utilisation du téléphone portable au volant est :',
                'options'       => ['Autorisée avec kit mains-libres', 'Interdite même avec kit mains-libres', 'Autorisée à l\'arrêt au feu rouge', 'Libre à chacun de décider'],
                'correct_index' => 0,
                'explication'   => 'L\'usage du téléphone est interdit sauf avec un dispositif mains-libres intégré au véhicule. Tenir le téléphone à la main est toujours interdit.',
            ],
        ];

        // ── Questions CONDUITE ────────────────────────────────
        $questionsConduite = [
            [
                'question'      => 'Avant de démarrer, que doit vérifier le conducteur en premier ?',
                'options'       => ['Le niveau d\'huile', 'Les rétroviseurs et le siège', 'La pression des pneus', 'Le plein de carburant'],
                'correct_index' => 1,
                'explication'   => 'Avant de démarrer, ajustez d\'abord votre siège et vos rétroviseurs (intérieur + extérieurs) pour avoir une visibilité optimale.',
            ],
            [
                'question'      => 'La technique de braquage du volant lors d\'un créneau requiert :',
                'options'       => ['Un seul mouvement rapide', 'Des mouvements croisés précis', 'De tourner uniquement à droite', 'D\'utiliser le frein à main'],
                'correct_index' => 1,
                'explication'   => 'Le créneau nécessite des mouvements croisés précis (pousser-tirer) pour maintenir le contrôle et la douceur de la direction.',
            ],
            [
                'question'      => 'Lors d\'un virage à droite en ville, la bonne position est :',
                'options'       => ['Au centre de la chaussée', 'Coller le trottoir droit', 'Se positionner à droite avant le virage', 'Rester à gauche'],
                'correct_index' => 2,
                'explication'   => 'Pour tourner à droite, se rapprocher du bord droit de la chaussée avant le virage, en réduisant la vitesse progressivement.',
            ],
            [
                'question'      => 'Comment s\'effectue correctement un démarrage en côte ?',
                'options'       => ['Relâcher l\'embrayage rapidement', 'Utiliser le frein à main + doser embrayage + accélérateur', 'Accélérer à fond puis relâcher', 'Ne pas utiliser le frein à main'],
                'correct_index' => 1,
                'explication'   => 'En côte : frein à main serré, moteur embrayé jusqu\'au point de patinage, puis relâcher le frein à main tout en maintenant les gaz.',
            ],
            [
                'question'      => 'La distance de sécurité recommandée correspond à :',
                'options'       => ['5 mètres fixes', '2 secondes de temps de réaction minimum', 'La longueur d\'un véhicule', '1 seconde par 10 km/h'],
                'correct_index' => 1,
                'explication'   => 'La règle des 2 secondes est universelle : choisissez un repère fixe, le véhicule devant passe dessus, comptez 2 secondes minimum avant de le passer aussi.',
            ],
            [
                'question'      => 'Lors d\'une conduite de nuit, les feux de route (pleins phares) doivent être éteints :',
                'options'       => ['Uniquement en ville', 'Dès qu\'un véhicule arrive en face ou vous précède', 'Jamais, ils sont toujours utiles', 'Uniquement sur autoroute'],
                'correct_index' => 1,
                'explication'   => 'Les feux de route doivent être basculés en feux de croisement (codes) dès qu\'un véhicule arrive en sens inverse ou vous précède, pour ne pas éblouir.',
            ],
            [
                'question'      => 'Qu\'est-ce que l\'aquaplaning ?',
                'options'       => ['Une technique de dépassement rapide', 'La perte d\'adhérence sur sol mouillé', 'Un type de freinage d\'urgence', 'La conduite en montagne'],
                'correct_index' => 1,
                'explication'   => 'L\'aquaplaning (ou aquaplanage) se produit quand un film d\'eau s\'interpose entre les pneus et la chaussée, causant une perte totale d\'adhérence et de direction.',
            ],
            [
                'question'      => 'Comment freiner efficacement en cas d\'urgence avec ABS ?',
                'options'       => ['Pomper les freins rapidement', 'Appuyer fort et maintenir sans relâcher', 'Freiner doucement pour éviter le blocage', 'Freiner et braquer en même temps'],
                'correct_index' => 1,
                'explication'   => 'Avec l\'ABS, appuyez fort sur la pédale et maintenez la pression — le système gère l\'antiblocage automatiquement. Ne pompez pas les freins.',
            ],
            [
                'question'      => 'La règle de conduite sur voie rapide lors d\'une insertion est :',
                'options'       => ['S\'arrêter et attendre un créneau', 'Accélérer pour atteindre la vitesse du trafic avant de s\'insérer', 'Forcer son passage', 'Rester sur la voie d\'accélération indéfiniment'],
                'correct_index' => 1,
                'explication'   => 'Sur voie d\'insertion, accélérez progressivement pour atteindre la vitesse du flux avant de vous insérer, en vérifiant vos angles morts.',
            ],
            [
                'question'      => 'Le rétroviseur intérieur doit permettre de voir :',
                'options'       => ['Le côté gauche du véhicule', 'La totalité de la lunette arrière', 'Le côté droit du véhicule', 'Le tableau de bord'],
                'correct_index' => 1,
                'explication'   => 'Le rétroviseur central (intérieur) doit être réglé pour voir entièrement la lunette arrière. Les angles morts restent à vérifier physiquement.',
            ],
        ];

        // Insertion en BDD
        foreach ($questionsCode as $q) {
            QuizQuestion::create(array_merge($q, ['category' => 'code']));
        }

        foreach ($questionsConduite as $q) {
            QuizQuestion::create(array_merge($q, ['category' => 'conduite']));
        }

        $this->command->info('✅ ' . count($questionsCode) . ' questions Code + ' . count($questionsConduite) . ' questions Conduite insérées.');
    }
}