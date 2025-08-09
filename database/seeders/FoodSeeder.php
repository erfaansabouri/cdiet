<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder {
    public function run (): void {

        foreach ( FoodCategory::all() as $food_category ) {
            for($i=0; $i<rand(8,20); $i++){
                $food_category->food()
                              ->create([
                                           'title' => Factory::create('fa_IR')->firstName ,
                                           'calorie' => rand(1 , 1000) + 0.1 ,
                                           'carbohydrate' => rand(1 , 1000) + 0.2 ,
                                           'fat' => rand(1 , 1000) + 0.3 ,
                                           'protein' => rand(1 , 1000) + 0.4 ,
                                       ]);
            }

        }
    }
}
