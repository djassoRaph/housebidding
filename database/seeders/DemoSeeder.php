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

        Property::update([
            'title' => 'Apartement de démonstration',
            'description' => 'Belle Apartement située dans le centre-ville.',
            'location' => 'Valbonne',
            'starting_price' => 280000,
            'min_increment' => 2500,
            'end_at' => now()->addDays(7), //Edit this later for when release to prod
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('supersecret'),
            'is_admin' => true,
        ]);

    }
}
