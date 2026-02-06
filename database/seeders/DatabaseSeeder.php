<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;

class DatabaseSeeder extends Seeder
{
    
    use WithoutModelEvents;
    

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $categoryNames = ["Peripherals","Office","Gaming","Audio"];
        foreach ($categoryNames as $name) {
            Category::create(['name' => $name]);
        }
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Product::factory()->create([
            'name'=> 'Some sort of product',
            'description'=>"Some sort of description for the product.",
            'price'=>random_int(10,1000),
            'category_id' => function() {
                return Category::inRandomOrder()->first()->id;
            },
            'available'=>true
        ]);
        Product::factory()->create([
            'name'=> 'Some sort of product that isnt available',
            'description'=>"Some sort of description for the product.",
            'price'=>random_int(10,1000),
            'category_id' => function() {
                return Category::inRandomOrder()->first()->id;
            },
            'available'=>false
        ]);

    }
}
