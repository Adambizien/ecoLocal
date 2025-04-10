<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Donation;
use App\Models\ProjectLevel;
use App\Models\RewardTier;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Création des catégories
        $categories = [
            'Technologie',
            'Art & Création',
            'Environnement',
            'Éducation',
            'Santé'
        ];

        foreach ($categories as $categoryName) {
            Categories::create(['name' => $categoryName]);
        }

        // Création de l'admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Création des porteurs de projet
        $projectLeaders = [];
        for ($i = 0; $i < 5; $i++) {
            $projectLeaders[] = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => 'project_leader',
            ]);
        }

        // Création des contributeurs
        $contributors = [];
        for ($i = 0; $i < 15; $i++) {
            $contributors[] = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }

        // Création des projets
        $projects = [];
        foreach ($projectLeaders as $leader) {
            for ($i = 0; $i < 2; $i++) {
                $projects[] = Project::create([
                    'user_id' => $leader->id,
                    'category_id' => Categories::inRandomOrder()->first()->id,
                    'title' => $faker->sentence,
                    'description' => $faker->paragraphs(3, true),
                    'goal_amount' => rand(5000, 20000),
                    'start_date' => now()->subDays(rand(1, 30)),
                    'end_date' => now()->addDays(rand(30, 90)),
                    'validated' => true,
                ]);
            }
        }

        // Création des paliers pour chaque projet
        foreach ($projects as $project) {
            $levels = [
                ['title' => 'Premier palier', 'percentage' => 0.2],
                ['title' => 'Palier intermédiaire', 'percentage' => 0.5],
                ['title' => 'Objectif principal', 'percentage' => 1],
                ['title' => 'Stretch goal 1', 'percentage' => 1.2],
                ['title' => 'Stretch goal 2', 'percentage' => 1.5],
            ];

            foreach (array_slice($levels, 0, rand(3, 5)) as $level) {
                ProjectLevel::create([
                    'project_id' => $project->id,
                    'title' => $level['title'],
                    'description' => "Atteindre ".($level['percentage']*100)."% de l'objectif pour débloquer cette étape",
                    'target_amount' => $project->goal_amount * $level['percentage'],
                ]);
            }

            // Création des niveaux de récompense
            $tiers = [
                ['title' => 'Soutien de base', 'amount' => 10],
                ['title' => 'Contributeur actif', 'amount' => 50],
                ['title' => 'Super contributeur', 'amount' => 100],
                ['title' => 'Mécène', 'amount' => 250],
                ['title' => 'Partenaire premium', 'amount' => 500],
            ];

            foreach (array_slice($tiers, 0, rand(3, 5)) as $tier) {
                RewardTier::create([
                    'project_id' => $project->id,
                    'title' => $tier['title'],
                    'description' => "Contreparties spéciales pour les dons de {$tier['amount']}€ et plus",
                    'minimum_amount' => $tier['amount'],
                ]);
            }
        }

        // Création des dons
        foreach ($projects as $project) {
            $contributorsForProject = array_rand($contributors, rand(5, 10));
            
            foreach ($contributorsForProject as $contributorIndex) {
                $donationsPerUser = rand(1, 3);
                
                for ($i = 0; $i < $donationsPerUser; $i++) {
                    $amount = rand(5, 500);
                    $donation = Donation::create([
                        'user_id' => $contributors[$contributorIndex]->id,
                        'project_id' => $project->id,
                        'amount' => $amount,
                        'created_at' => now()->subDays(rand(0, 30)),
                    ]);

                    // Associer les récompenses éligibles
                    $eligibleTiers = RewardTier::where('project_id', $project->id)
                        ->where('minimum_amount', '<=', $amount)
                        ->get();

                    if ($eligibleTiers->isNotEmpty()) {
                        $donation->rewardTiers()->attach(
                            $eligibleTiers->random(rand(1, $eligibleTiers->count()))->pluck('id')->toArray()
                        );
                    }
                }
            }
        }

        // Création d'utilisateurs supplémentaires
        for ($i = 0; $i < 5; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }
    }
}