<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Formation;

class FormationSeeder extends Seeder
{
    public function run(): void
    {
        Formation::create([
            'titre' => 'Développement Web Laravel',
            'description' => 'Apprenez à créer des applications web modernes et robustes avec le framework PHP le plus populaire.',
            'formateur' => 'Jean Dupont',
            'duree' => '5 jours',
            'date_debut' => '2026-06-15',
        ]);

        Formation::create([
            'titre' => 'Docker pour débutants',
            'description' => 'Maîtrisez la conteneurisation de vos applications avec Docker et Docker Compose.',
            'formateur' => 'Alice Martin',
            'duree' => '3 jours',
            'date_debut' => '2026-07-10',
        ]);

        Formation::create([
            'titre' => 'Introduction au DevOps',
            'description' => 'Découvrez les concepts et les pratiques DevOps pour accélérer vos déploiements.',
            'formateur' => 'Paul Durand',
            'duree' => '2 jours',
            'date_debut' => '2026-08-05',
        ]);
    }
}
