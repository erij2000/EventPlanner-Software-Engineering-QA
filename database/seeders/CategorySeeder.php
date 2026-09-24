<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Conférence'],
            ['name' => 'Atelier'],
            ['name' => 'Concert'],
            ['name' => 'Exposition'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate($cat);
        }

        $this->command->info('Categories seeded!');
    }
}
