<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            [
                'title' => 'Burger',
                'slug' => 'burger',
                'status' => 1,
                'show_at_home' => 1,
            ],
            [
                'title' => 'Sandwich',
                'slug' => 'sandwich',
                'status' => 1,
                'show_at_home' => 1,
            ],
            [
                'title' => 'Taco',
                'slug' => 'taco',
                'status' => 1,
                'show_at_home' => 1,
            ],
        ]);
    }
}
