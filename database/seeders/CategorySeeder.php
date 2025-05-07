<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Electronics',
                'description' => 'All kinds of electronics',
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel for all ages',
            ],
            [
                'name' => 'Books',
                'description' => 'A variety of books',
            ]
        ]);
    }
}
