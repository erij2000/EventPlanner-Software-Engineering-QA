<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@event.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );

        // 2. Create Normal User
        User::firstOrCreate(
            ['email' => 'user@event.com'],
            [
                'name' => 'hela',
                'password' => Hash::make('user123'),
                'role' => 'user'
            ]
        );

        // 3. Create Categories
        $categoryNames = ['Music', 'Tech', 'Art', 'Sports'];
        foreach ($categoryNames as $name) {
            Category::firstOrCreate(['name' => $name]);
        }

        // Get IDs for assignment
        $musicId = Category::where('name', 'Music')->first()->id;
        $artId = Category::where('name', 'Art')->first()->id;
        $sportsId = Category::where('name', 'Sports')->first()->id;

        // 4. Create Events using YOUR LOCAL IMAGES
        $events = [
            [
                'title' => "Exposition d'Art",
                'description' => 'Découvrez des œuvres locales incroyables.',
                'start_date' => now()->addDays(5)->setHour(10),
                'end_date' => now()->addDays(5)->setHour(18),
                'place' => 'Musée National',
                'capacity' => 30,
                'price' => 10,
                'is_free' => false,
                'category_id' => $artId,
                'image' => 'football.jpg', // Matches your file in storage/app/public
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Match de Football',
                'description' => 'Venez encourager votre équipe.',
                'start_date' => now()->addDays(10)->setHour(20),
                'end_date' => now()->addDays(10)->setHour(22),
                'place' => 'Stade Municipal',
                'capacity' => 100,
                'price' => 0,
                'is_free' => true,
                'category_id' => $sportsId,
                'image' => 'exposition-art.webp', // Matches your file in storage/app/public
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Jazz Night',
                'description' => 'Soirée Jazz au clair de lune.',
                'start_date' => now()->addDays(2),
                'end_date' => now()->addDays(2)->addHours(4),
                'place' => 'Club Jazz',
                'capacity' => 20,
                'price' => 15,
                'is_free' => false,
                'category_id' => $musicId,
                'image' => 'jazz.avif', // Online image
                'created_by' => $admin->id,
            ]
        ];
         
        foreach ($events as $e) {
            Event::create($e);
        }

        $this->command->info('Database seeded successfully with local and online images!');
    }
}