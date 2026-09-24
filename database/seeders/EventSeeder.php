<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Category;
use App\Models\User;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Get the admin user we created in DatabaseSeeder
        $admin = User::where('role', 'admin')->first();
        
        // Get categories
        $categories = Category::all();

        $events = [
            [
                'title' => "Exposition d'Art",
                'description' => 'Une galerie moderne avec des artistes locaux.',
                'start_date' => now()->addDays(5)->setHour(10),
                'end_date' => now()->addDays(5)->setHour(18),
                'place' => 'Musée des Beaux-Arts',
                'capacity' => 30,
                'price' => 12.00,
                'is_free' => false,
                'category_id' => $categories->where('name', 'Art')->first()->id ?? 1,
                'image' => 'football.jpg', // Matches your file in storage/app/public
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Match de Football',
                'description' => 'Grande finale de la coupe régionale.',
                'start_date' => now()->addDays(12)->setHour(20),
                'end_date' => now()->addDays(12)->setHour(22),
                'place' => 'Stade Olympique',
                'capacity' => 500,
                'price' => 0,
                'is_free' => true,
                'category_id' => $categories->where('name', 'Sports')->first()->id ?? 1,
                'image' => 'exposition-art.webp', // Matches your file in storage/app/public
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Jazz Summer Night',
                'description' => 'Concert de Jazz en plein air.',
                'start_date' => now()->addDays(20),
                'end_date' => now()->addDays(20)->addHours(4),
                'place' => 'Parc Central',
                'capacity' => 100,
                'price' => 25.00,
                'is_free' => false,
                'category_id' => $categories->where('name', 'Music')->first()->id ?? 1,
                'image' => 'jazz.avif', // Online fallback
                'created_by' => $admin->id,
            ],
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }

        $this->command->info('EventSeeder finished with local images!');
    }
}