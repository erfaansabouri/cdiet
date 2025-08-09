<?php

namespace Database\Seeders;

use App\Models\DietaryCookingCategory;
use App\Models\ExerciseCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DietaryCookingSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run (): void {
        foreach ( DietaryCookingCategory::all() as $category ) {
            for ( $i = 0 ; $i < 30 ; $i++ ) {
                $category->dietaryCookings()
                                  ->create([
                                               'title' => Factory::create('fa_IR')->sentence ,
                                               'description' => Factory::create('fa_IR')->paragraph ,
                                           ]);
            }
        }
    }
}
