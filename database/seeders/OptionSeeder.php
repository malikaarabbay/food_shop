<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::insert([
            [
                'title' => 'Select Size',
                'status' => 1,
            ],
            [
                'title' => 'Select Option',
                'status' => 1,
            ],
        ]);
    }
}
