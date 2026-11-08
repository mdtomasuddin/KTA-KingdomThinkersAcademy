<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Release',
                'slug' => 'release',
            ],
            [
                'name' => 'Clarity',
                'slug' => 'clarity',
            ],
            [
                'name' => 'Healing',
                'slug' => 'healing',
            ],
            [
                'name' => 'Gratitude',
                'slug' => 'gratitude',
            ],
            [
                'name' => 'Peace',
                'slug' => 'peace',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
