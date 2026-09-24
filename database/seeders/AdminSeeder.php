<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Crée l'admin seulement s'il n'existe pas déjà
        User::firstOrCreate(
            ['email' => 'admin@event.com'], // critère unique
            [
                'name' => 'Admin',
                'password' => bcrypt('admin123'), // mot de passe initial
                'role' => 'admin',
            ]
        );

        $this->command->info('Admin user seeded successfully!');
    }
}
