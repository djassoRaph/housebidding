<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Utilisateur Démo',
            'email' => 'demo@example.com',
            'password' => bcrypt('password'),
        ]);

        Property::updateOrCreate(
            ['title' => 'Appartement de Julien GOETZ'], // Unique identifying field
            [
                'description' => 'Belle appartement située dans le centre-ville.',
                'location' => 'Valbonne',
                'starting_price' => 280000,
                'min_increment' => 2500,
                'end_at' => now()->addDays(7),
            ]
        );

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('supersecret'),
            'is_admin' => true,
        ]);

    }
}
