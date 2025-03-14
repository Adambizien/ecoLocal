<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Tier;
use App\Models\Donation;
use App\Models\User;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Créer un utilisateur de test si aucun n'existe
        if (User::count() === 0) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

            User::factory(9)->create();
        }

        $users = User::pluck('id')->toArray();

        if (empty($users)) {
            $this->command->warn('Aucun utilisateur trouvé. Crée d\'abord des utilisateurs.');
            return;
        }

        // Créer 10 projets aléatoires
        for ($i = 0; $i < 10; $i++) {
            $project = Project::create([
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph(),
                'goal_amount' => $faker->randomFloat(2, 1000, 10000),
                'raised_amount' => 0,
                'start_date' => $faker->date(),
                'end_date' => $faker->date(),
                'status' => $faker->randomElement(['en cours', 'terminé', 'annulé']),
                'user_id' => $faker->randomElement($users)
            ]);

            // Créer 3 paliers pour chaque projet
            for ($j = 0; $j < 3; $j++) {
                $tier = Tier::create([
                    'project_id' => $project->id,
                    'title' => 'Palier ' . ($j + 1),
                    'goal_amount' => $faker->randomFloat(2, 500, 5000),
                    'description' => $faker->sentence()
                ]);
            }

            // Créer 5 donations pour chaque projet
            for ($k = 0; $k < 5; $k++) {
                Donation::create([
                    'project_id' => $project->id,
                    'amount' => $faker->randomFloat(2, 10, 500),
                    'user_id' => $faker->randomElement($users)
                ]);
            }
        }
    }
}