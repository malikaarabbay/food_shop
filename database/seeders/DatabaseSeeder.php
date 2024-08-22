<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use App\Models\Coupon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(WhyChooseUsTitleSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(OptionSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(SettingSeeder::class);
        Slider::factory(3)->create();
        WhyChooseUs::factory(3)->create();
        Product::factory(10)->create();
        Coupon::factory(3)->create();
    }
}
