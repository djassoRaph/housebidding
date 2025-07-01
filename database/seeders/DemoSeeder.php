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

        Property::create([
            'title' => 'Maison de démonstration',
            'description' => 'Belle maison située dans le centre-ville.',
            'location' => 'Paris',
            'starting_price' => 100000,
            'min_increment' => 1000,
            'end_at' => now()->addDays(7),
        ]);
    }
}
